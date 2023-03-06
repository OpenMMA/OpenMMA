<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;

class Role extends \Spatie\Permission\Models\Role
{
    use HasFactory;

    public static function getGroup($group)
    {
        return Role::where('name', 'LIKE', "$group.%")->get();
    }

    public static function getGroupMembers($group)
    {
        $role = $group . '.';
        return User::all()->filter(fn($user) => $user->hasRole($role) ? $user : false);
    }
}
