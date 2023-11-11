<?php

namespace App\Livewire\Profile;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Profile extends Component
{
    public string $first_name;
    public string $last_name;
    public string $email;
    public array $custom_data;

    public function mount()
    {
        $user = Auth::user();
        $this->first_name = $user->first_name;
        $this->last_name = $user->last_name;
        $this->email = $user->email;
        $this->custom_data = $user->custom_data;
    }

    public function render()
    {
        $user = Auth::user();
        $custom_fields = setting('account.custom_fields');
        $custom_fields = array_map(fn($v) => (object)$v, $custom_fields);
        $custom_fields = array_map(fn($v) => (object)array_merge((array)$v, [
            'attributes' => "wire:model=\"custom_data.$v->name\"",
        ]), $custom_fields);

        return view('livewire.profile.profile', [
            'custom_fields' => $custom_fields,
        ]);
    }

    public function update()
    {
        $this->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email',
        ]);

        $user = Auth::user();
        $user->first_name = $this->first_name;
        $user->last_name = $this->last_name;
        $user->email = $this->email;
        $user->custom_data = $this->custom_data;
        $user->save();
    }
}
