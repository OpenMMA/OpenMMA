<?php

namespace App\Models\Groups;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Permission extends \Spatie\Permission\Models\Permission
{
    use HasFactory;

    public static $group_permissions = [
        'create_event' => 'Create event',
        'edit_event' => 'Edit event',
        'publish_event' => 'Publish event',
        'delete_event' => 'Delete event',
        
        'view_registrations' => 'View registrations',
        'manage_registrations' => 'Manage registrations',
        'view_statistics' => 'View registration statistics',

        'create_role' => 'Create role',
        'edit_role' => 'Edit role',
        'assign_role' => 'Assign role to member',
        'delete_role' => 'Delete role',
    ];
    public static $global_permissions = [
        'create_group' => 'Create group',
        'edit_group' => 'Edit group',
        'delete_group' => 'Delete group',
        
        'give_global_permissions' => 'Allow granting global permissions',
        
        'view_users' => 'View members',
        'manage_users' => 'Manage members',
        'assign_users' => 'Assign user to group',
    ];

    public static function createPermissionsForGroup($group)
    {
        array_map(
            fn($permission_name) => 
                Permission::create(['name' => $group . '.' . $permission_name]),
            array_keys(Permission::$group_permissions)
        );
    }

    public static function getPermissionsForGroup($group)
    {
        return Permission::where('name', 'LIKE', $group.'.%')->get();
    }
}
