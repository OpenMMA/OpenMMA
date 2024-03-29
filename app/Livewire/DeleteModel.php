<?php

namespace App\Livewire;

use App\Models\Groups\Group;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class DeleteModel extends Component
{
    public Model $model;
    public $selector_id;

    public function mount()
    {
        $this->selector_id = bin2hex(random_bytes(8));
    }

    public function delete()
    {
        switch (get_class($this->model)) {
            case "App\Models\Groups\Group":
            case "App\Models\Groups\GroupCategory":
                if (!Auth::user()->can('group.delete'))
                    return;
                break;
            case "App\Models\Groups\Role":
                if ($this->model->isBaseRole == 1)
                    return;
                if (!Auth::user()->can(Group::find($this->model->group)->name.'.role.delete'))
                    return;
                break;
            default:
               return;
        }
        $this->model->delete();
        $this->dispatch('deleted');
    }

    public function render()
    {
        return view('livewire.delete-model');
    }
}
