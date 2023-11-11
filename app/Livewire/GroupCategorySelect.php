<?php

namespace App\Livewire;

use App\Models\Groups\Group;
use App\Models\Groups\GroupCategory;
use Livewire\Component;

class GroupCategorySelect extends Component
{
    public Group $group;
    public int $category;

    public function mount()
    {
        $this->category = $this->group->category ?? -1;
    }

    public function saveCategory()
    {
        $this->group->category = ($this->category >= 0) ? $this->category : null;
        $this->group->save();
    }

    public function render()
    {
        return view('livewire.group-category-select', ['group_id' => $this->group->id, 'categories' => GroupCategory::all()]);
    }
}
