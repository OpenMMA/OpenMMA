<?php

namespace App\Models\Groups;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Permission extends \Spatie\Permission\Models\Permission
{
    use HasFactory;

    public static $group_permissions = [
        'event.create' => 'Create event',
        'event.edit' => 'Edit event',
        'event.publish' => 'Publish event',
        'event.delete' => 'Delete event',
        'event.*' => 'Complete event control',

        'registration.view' => 'View registrations',
        'registration.manage' => 'Manage registrations',
        'registration.statistics' => 'View registration statistics',
        'registration.*' => 'Complete registration control',

        'role.create' => 'Create role',
        'role.edit' => 'Edit role',
        'role.assign' => 'Assign role to member',
        'role.delete' => 'Delete role',
        'role.*' => 'Complete role control',

        'setting.general' => 'Manage general group settings',
        'setting.*' => 'Manage all group settings',
    ];
    public static $global_permissions = [
        'group.create' => 'Create group',
        'group.edit' => 'Edit group',
        'group.delete' => 'Delete group',
        'group.*' => 'Complete group control',

        'give_global_permissions' => 'May grant global permissions',

        'user.view' => 'View members',
        'user.manage' => 'Manage members',
        'user.assign' => 'Assign member to group',
        'user.*' => 'Complete member control',

        'global_setting.system' => 'Manage global system settings',
        'global_setting.*' => 'Manage all global settings',
    ];
    public static $implicit_permissions = [
        'may_access_dashboard' => 'Can access dashboard (SHOULD BE SET AUTOMATICALLY)'
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
