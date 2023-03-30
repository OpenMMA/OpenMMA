<?php

namespace App\Models;

use App\Models\Groups\Role;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'custom_data',
        'user_verified_at'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'custom_data' => 'json',
    ];


    public static function create(array $attributes = [])
    {
        $model = static::query()->create($attributes);
        $custom_data = json_decode($model->custom_data);

        $fields = setting('account.custom_fields');
        foreach ($fields as $field) {
            $name = $field->name;
            if (!isset($custom_data->$name)) {
                $custom_data[$name] = $field->default ?? null;
            }
        }
        $model->update(['custom_data' => $custom_data]);

        return $model;
    }


    // public function sendEmailVerificationNotification()
    // {
    //     // Make sure notifiaction email is queued to prevent error:500 when mail server not working
    //     $this->notify(new \App\Notifications\VerifyEmailQueued);
    // }

    public function getNameAttribute(): string
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function getEmailVerifiedAttribute(): bool
    {
        return $this->email_verified_at != null;
    }

    public function getUserVerifiedAttribute(): bool
    {
        return $this->user_verified_at != null;
    }

    public function getGroupsAttribute(): Collection
    {
        // TODO can this be done more efficiently?
        $role_ids = DB::table('model_has_roles')
                      ->where([['model_id', $this->id], ['model_type', get_class($this)]])
                      ->get('role_id')->toArray();
        return Role::where('isBaseRole', true)->find(array_map(fn($val) => $val->role_id, $role_ids));
    }

    public function getRoleIdsAttribute(): Collection
    {
        // TODO can this be done more efficiently?
        return DB::table('model_has_roles')
                 ->where([['model_id', $this->id], ['model_type', get_class($this)]])
                 ->get('role_id')->map(fn($n) => $n->role_id);
    }

    public function getRolesAttribute(): Collection
    {
        // TODO can this be done more efficiently?
        return Role::where('isBaseRole', false)->find($this->role_ids);
    }

    public static function syncCustomFields(array $old_fields, array $new_fields)
    {
        $old_field_names = array_map(fn($n) => $n['name'], $old_fields);
        $new_field_names = array_map(fn($n) => $n['name'], $new_fields);

        $remove_fields    = array_diff($old_field_names, $new_field_names);
        $introduce_fields = array_diff($new_field_names, $old_field_names);

        $new_fields = array_combine($new_field_names, $new_fields);

        foreach (User::all() as $user) {
            $data = $user->custom_data;
            foreach ($remove_fields as $field)
                unset($data[$field]);
            foreach ($introduce_fields as $field)
                $data[$field] = $new_fields[$field]['default'] ?? (($new_fields[$field]['multiple'] ?? false) ? [] : null); // TODO better type-defined default values
            $user->update(['custom_data' => $data]);
        }
    }
}
