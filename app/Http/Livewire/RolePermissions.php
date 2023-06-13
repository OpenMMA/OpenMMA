<?php

namespace App\Http\Livewire;

use App\Models\Groups\Group;
use App\Models\Groups\Permission;
use App\Models\Groups\Role;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class RolePermissions extends Component
{
    use AuthorizesRequests;

    public Role $role; // TODO protect against user tampering
    public Group $group; // TODO protect against user tampering
    public array $group_permissions;
    public array $global_permissions;
    public bool $global_permissions_enabled;
    public array $group_permission_defenition = [
        0 => [
            'label' => 'events',
            'elements' => [
                'event.create',
                'event.edit',
                'event.publish',
                'event.delete',
            ]
        ],
        1 => [
            'label' => 'registrations',
            'elements' => [
                'registration.view',
                'registration.manage',
                'registration.statistics',
            ]
        ],
        2 => [
            'label' => 'roles',
            'elements' => [
                'role.create',
                'role.edit',
                'role.assign',
                'role.delete',
            ]
        ],
        3 => [
            'label' => 'settings',
            'elements' => [
                'setting.general',
            ]
        ]
    ];
    public array $global_permission_defenition = [
        0 => [
            'label' => 'Events',
            'elements' => [
                'event.create',
                'event.edit',
                'event.publish',
                'event.delete',
            ]
        ],
        1 => [
            'label' => 'Registrations',
            'elements' => [
                'registration.view',
                'registration.manage',
                'registration.statistics',
            ]
        ],
        2 => [
            'label' => 'Roles',
            'elements' => [
                'role.create',
                'role.edit',
                'role.assign',
                'role.delete',
                'give_global_permissions',
            ]
        ],
        3 => [
            'label' => 'Groups',
            'elements' => [
                'group.create',
                'group.edit',
                'group.delete',
            ]
        ],
        4 => [
            'label' => 'Members',
            'elements' => [
                'user.view',
                'user.manage',
                'user.assign',
            ]
            ],
        5 => [
            'label' => 'Settings',
            'elements' => [
                'setting.general',
                'global_setting.system',
            ]
        ]

    ];

    protected $rules = [
        'permissions.*' => 'bool'
    ];

    private static function flatten(array $array): array
    {
        // NOTE only works with 2-dimensional arrays!!!
        foreach ($array as $key => $val) {
            if (is_array($val)) {
                foreach ($val as $subkey => $subval)
                    $array[$key.'.'.$subkey] = $subval;
                unset($array[$key]);
            }
        }
        return $array;
    }

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
        $group = explode('.', $this->role->name, 2)[0];
        // TODO Should we use $this->authorize()?
        if (!Auth::user()->can($group.'.role.edit'))
            return; // TODO error message?

        $this->group_permissions = $this::flatten($this->group_permissions);
        foreach ($this->group_permissions as $permission => $has_permission) {
            if ($has_permission)
                $this->role->givePermissionTo($group.'.'.$permission);
            else
                $this->role->revokePermissionTo($group.'.'.$permission);
        }

        // Make sure access to the dashboard is granted when access is required
        if (in_array(true, $this->group_permissions) || in_array(true, $this->global_permissions))
            $this->role->givePermissionTo('may_access_dashboard');
        else
            $this->role->revokePermissionTo('may_access_dashboard');
    }

    public function updateGlobalPermissions()
    {
        $group = explode('.', $this->role->name, 2)[0];
        // TODO Should we use $this->authorize()?
        if (!Auth::user()->can($group.'.role.edit') && !Auth::user()->can('give_global_permissions'))
            return; // TODO error message?


        $this->global_permissions = $this::flatten($this->global_permissions);
        foreach ($this->global_permissions as $permission => $has_permission) {
            $prefix = array_key_exists($permission, Permission::$global_permissions) ? '' : '*.';
            if ($has_permission)
                $this->role->givePermissionTo($prefix.$permission);
            else
                $this->role->revokePermissionTo($prefix.$permission);
        }

        // Make sure access to the dashboard is granted when access is required
        if (in_array(true, $this->group_permissions) || in_array(true, $this->global_permissions))
            $this->role->givePermissionTo('may_access_dashboard');
        else
            $this->role->revokePermissionTo('may_access_dashboard');
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
