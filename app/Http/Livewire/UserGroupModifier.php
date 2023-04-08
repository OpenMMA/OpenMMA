<?php

namespace App\Http\Livewire;

use App\Models\Groups\Group;
use App\Models\Groups\Role;
use App\Models\User;
use Livewire\Component;

class UserGroupModifier extends Component
{
    public User $user; // TODO protect against user tampering
    public Group $group; // TODO protect against user tampering
    public bool $render_add = false;
    public bool $render_remove = false;

    public function add()
    {
        $this->user->assignRole($this->group->name.'.');
        $this->emit('refreshUserTable');
    }

    public function remove()
    {
        foreach (Role::where('name', 'LIKE', $this->group->name.'.%')->get() as $role)
            $this->user->removeRole($role);
        $this->emit('refreshUserTable');
    }

    public function render()
    {
        return view('livewire.user-group-modifier');
    }
}
