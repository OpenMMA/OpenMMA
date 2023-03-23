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
}
