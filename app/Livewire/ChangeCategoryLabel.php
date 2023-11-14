<?php

namespace App\Livewire;

use App\Models\Groups\GroupCategory;
use Livewire\Component;

class ChangeCategoryLabel extends Component
{
    public GroupCategory $category;
    public string $label;

    public function mount()
    {
        $this->label = $this->category->label;
    }

    public function save()
    {
        $this->category->label = $this->label;
        $this->category->save();
    }

    public function render()
    {
        return view('livewire.change-category-label');
    }
}
