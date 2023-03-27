<?php

namespace App\Http\Livewire;

use App\Models\Groups\Group;
use App\Models\Groups\Permission;
use App\Models\Groups\Role;
use Livewire\Component;

class RolePermissions extends Component
{
    public Role $role;
    public Group $group;
    public array $group_permissions;
    public array $global_permissions;
    public bool $global_permissions_enabled;
    public array $group_permission_defenition = [
        0 => [
            'label' => 'events',
            'elements' => [
                'create_event',
                'edit_event',
                'publish_event',
                'delete_event',
            ]
        ],
        1 => [
            'label' => 'registrations',
            'elements' => [
                'view_registrations',
                'manage_registrations',
                'view_statistics',
            ]
        ],
        2 => [
            'label' => 'roles',
            'elements' => [
                'create_role',
                'edit_role',
                'assign_role',
                'delete_role',
            ]
        ],
    ];
    public array $global_permission_defenition = [
        0 => [
            'label' => 'Events',
            'elements' => [
                'create_event',
                'edit_event',
                'publish_event',
                'delete_event',
            ]
        ],
        1 => [
            'label' => 'Registrations',
            'elements' => [
                'view_registrations',
                'manage_registrations',
                'view_statistics',
            ]
        ],
        2 => [
            'label' => 'Roles',
            'elements' => [
                'create_role',
                'edit_role',
                'assign_role',
                'delete_role',
                'give_global_permissions',
            ]
        ],
        3 => [
            'label' => 'Groups',
            'elements' => [
                'create_group',
                'edit_group',
                'delete_group',
            ]
        ],
        4 => [
            'label' => 'Members',
            'elements' => [
                'view_users',
                'manage_users',
                'assign_users',
            ]
        ]

    ];

    protected $rules = [
        'permissions.*' => 'bool'
    ];

    public function mount()
    {
        $group = explode('.', $this->role->name, 2)[0];
        $group_permissions = array_merge(...array_map(fn($n) => $n['elements'], $this->group_permission_defenition));
        $global_permissions = array_merge(...array_map(fn($n) => $n['elements'], $this->global_permission_defenition));
        $this->group = Group::where('name', $group)->first();
        $this->group_permissions = array_combine($group_permissions, array_map(fn($n) => $this->role->hasPermissionTo($group.'.'.$n), $group_permissions));
        $this->global_permissions = array_combine($global_permissions, array_map(fn($n) => $this->role->hasPermissionTo((array_key_exists($n, Permission::$global_permissions) ? '' : '*.').$n), $global_permissions));
        $this->global_permissions_enabled = false;
    }

    public function updateGroupPermissions()
    {
        // TODO Check if user is allowed to edit given role
        // $user->can($role->name.'edit_roles');
        $group = explode('.', $this->role->name, 2)[0];
        foreach ($this->group_permissions as $permission => $has_permission) {
            if ($has_permission)
                $this->role->givePermissionTo($group.'.'.$permission);
            else   
                $this->role->revokePermissionTo($group.'.'.$permission);
        }
    }

    public function updateGlobalPermissions()
    {
        // TODO Check if user is allowed to edit given role
        // $user->can($role->name.'edit_roles') && $user->can($role->name.'give_global_permissions');
        $group = explode('.', $this->role->name, 2)[0];
        foreach ($this->global_permissions as $permission => $has_permission) {
            $prefix = array_key_exists($permission, Permission::$global_permissions) ? '' : '*.';
            if ($has_permission)
                $this->role->givePermissionTo($prefix.$permission);
            else   
                $this->role->revokePermissionTo($prefix.$permission);
        }
    }

    public function enableGlobalPermissions()
    {
        $this->global_permissions_enabled = true;
    }

    public function render()
    {
        return view('livewire.role-permissions');
    }
}
