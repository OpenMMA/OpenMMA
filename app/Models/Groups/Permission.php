<?php

namespace App\Models\Groups;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Permission extends \Spatie\Permission\Models\Permission
{
    use HasFactory;

    public static $base_permissions = [
        'create_event' => 'Create event',
        'edit_event' => 'Edit event',
        'publish_event' => 'Publish event',
        'delete_event' => 'Delete event',
        
        'view_registrations' => 'View registrations',
        'manage_registrations' => 'Manage registrations',
        'view_statistics' => 'View registration statistics',

        'create_role' => 'Create role',
        'edit_role' => 'Edit role',
        'assign_role' => 'Assign role',
        'delete_role' => 'Delete role',
    ];
    public static $general_permissions = [
        'create_group' => 'Create group',
        'edit_group' => 'Edit group',
        'assign_group' => 'Assign user to group',
        'delete_group' => 'Delete group',

        'view_users' => 'View members',
        'manage_users' => 'Manage members',
    ];

    public static function createPermissionsForGroup($group)
    {
        array_map(
            fn($permission_name, $permission_label) => 
                Permission::create(['name' => $group . '.' . $permission_name, 'label' => $permission_label]),
            array_keys(Permission::$base_permissions),
            array_values(Permission::$base_permissions)
        );
    }

    public static function getPermissionsForGroup($group)
    {
        return Permission::where('name', 'LIKE', $group.'.%')->get();
    }
}
