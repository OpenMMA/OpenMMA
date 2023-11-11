<?php

namespace App\Livewire;

use App\Models\Groups\Group;
use App\Models\Groups\Role;
use Livewire\Component;

class RoleTable extends Component
{
    public Group $group;

    public function render()
    {
        $roles = Role::getGroupRoles($this->group->name);
        return view('livewire.role-table', ['roles' => $roles]);
    }
}
