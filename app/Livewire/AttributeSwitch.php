<?php

namespace App\Livewire;

use Illuminate\Database\Eloquent\Model;
use Livewire\Component;

class AttributeSwitch extends Component
{
    public Model $model;
    public string $attribute;
    public bool $isChecked;

    public function mount()
    {
        $this->isChecked = (bool)$this->model->getAttribute($this->attribute);
    }

    public function updating($field, $value)
    {
        $this->model->setAttribute($this->attribute, $value)->save();
    }

    public function render()
    {
        return view('livewire.attribute-switch');
    }
}
