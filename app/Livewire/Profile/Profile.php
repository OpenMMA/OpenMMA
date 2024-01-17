<?php

namespace App\Livewire\Profile;

use Livewire\Attributes\Locked;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Profile extends Component
{
    public string $first_name;
    public string $last_name;
    public string $email;
    public array $custom_data;
    #[Locked]
    public array $custom_fields;

    public function mount()
    {
        $user = Auth::user();

        $this->custom_fields = setting('account.custom_fields');
        $this->custom_fields = array_map(fn($v) => (object)$v, $this->custom_fields);
        $this->custom_fields = array_map(fn($v) => (object)array_merge((array)$v, [
            'wire' => "custom_data.$v->name",
        ]), $this->custom_fields);

        $this->first_name = $user->first_name;
        $this->last_name = $user->last_name;
        $this->email = $user->email;
        $this->custom_data = $user->custom_data;
        foreach ($this->custom_fields as $field) {
            if ($field->type == 'select' && $field->multiple ?? false) 
                $this->custom_data[$field->name] = json_encode($this->custom_data[$field->name]);
        }
    }

    public function render()
    {
        return view('livewire.profile.profile');
    }

    public function update()
    {
        // dd($this->custom_data);
        $this->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email',
        ]);

        $user = Auth::user();
        $user->first_name = $this->first_name;
        $user->last_name = $this->last_name;
        $user->email = $this->email;

        $custom_data = $this->custom_data;
        foreach ($this->custom_fields as $field) {
            if ($field->type == 'select' && $field->multiple ?? false) 
                $custom_data[$field->name] = json_decode($custom_data[$field->name]);
        }
        $user->custom_data = $custom_data;
    
        $user->save();
        // dd($custom_data);
    }
}
