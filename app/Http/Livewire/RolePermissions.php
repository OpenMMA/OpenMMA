<?php

namespace App\Http\Livewire;

use App\Models\Groups\Permission;
use App\Models\Groups\Role;
use Illuminate\Support\Collection;
use Livewire\Component;

class RolePermissions extends Component
{
    public Role $role;
    public Collection $permissions;
    public Collection $permission_labels;

    protected $rules = [
        'permissions.*' => 'bool'
    ];

    public function mount()
    {
        $group = explode('.', $this->role->name, 2)[0];
        $permissions = Permission::getPermissionsForGroup($group)->mapWithKeys(fn($n) => [explode('.', $n->name, 2)[1] => $n]);
        $this->permissions = $permissions->mapWithKeys(fn($n, $k) => [$k => $this->role->hasPermissionTo($group.'.'.$k)]);
        $this->permission_labels = $permissions->mapWithKeys(fn($n, $k) => [$k => $n->label]);
        // dd($this->permission_labels);
        // $permissions = array_keys($this->permissions->toArray());

        // $has_permissions = array_map(fn($permission) => $this->role->hasPermissionTo($permission), $permissions);
        // $this->has_permissions = array_combine($permissions, $has_permissions);
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
