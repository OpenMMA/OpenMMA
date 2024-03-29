<?php

namespace App\Models\Groups;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;

class Role extends \Spatie\Permission\Models\Role
{
    use HasFactory;

    // TODO should 'name' be fillable?
    protected $guarded = [];

    public function delete()
    {
        foreach ($this->users()->get() as $user) {
            $user->removeRole($this->name);
        }
        parent::delete();
    }

    public static function getGroupRoles($group) // TODO obselete?
    {
        return Role::where('name', 'LIKE', "$group._%")->get();
    }

    public static function getGroupMembers($group)
    {
        $role = $group . '.';
        return User::all()->filter(fn($user) => $user->hasRole($role) ? $user : false);
    }
}
