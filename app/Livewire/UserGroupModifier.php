<?php

namespace App\Livewire;

use App\Models\Groups\Group;
use App\Models\Groups\Role;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Locked;
use Livewire\Component;

class UserGroupModifier extends Component
{
    #[Locked]
    public User $user;
    #[Locked]
    public Group $group;
    public bool $render_add = false;
    public bool $render_remove = false;

    public function add()
    {
        if (!Auth::user()->can('user.assign'))
            return;
        
        $this->user->assignRole($this->group->name.'.');
        $this->dispatch('refreshUserTable');
    }

    public function remove()
    {
        if (!Auth::user()->can('user.assign'))
            return;

        foreach (Role::where('name', 'LIKE', $this->group->name.'.%')->get() as $role)
            $this->user->removeRole($role);
        $this->dispatch('refreshUserTable');
    }

    public function render()
    {
        return view('livewire.user-group-modifier');
    }
}
