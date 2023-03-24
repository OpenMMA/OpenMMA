<?php

namespace App\Http\Livewire;

use App\Models\Groups\Permission;
use App\Models\Groups\Role;
use Illuminate\Support\Collection;
use Livewire\Component;

class RolePermissions extends Component
{
    public Role $role;
    public array $permissions;
    public array $base_permission_defenition = [
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
            ]
        ],
    ];

    protected $rules = [
        'permissions.*' => 'bool'
    ];

    public function mount()
    {
        $group = explode('.', $this->role->name, 2)[0];
        $permissions = array_merge(...array_map(fn($n) => $n['elements'], $this->base_permission_defenition));
        $this->permissions = array_combine($permissions, array_map(fn($n) => $this->role->hasPermissionTo($group.'.'.$n), $permissions));
    }

    public function updatePermissions()
    {
        // TODO Check if user is allowed to edit given role
        // $user->can($role->name.'edit_roles');
        $group = explode('.', $this->role->name, 2)[0];
        foreach ($this->permissions as $permission => $has_permission) {
            if ($has_permission)
                $this->role->givePermissionTo($group.'.'.$permission);
            else   
                $this->role->revokePermissionTo($group.'.'.$permission);
        }
    }

    public function render()
    {
        return view('livewire.role-permissions');
    }
}
