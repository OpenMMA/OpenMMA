<?php

namespace App\Http\Livewire;

use App\Models\User;
use Carbon\Carbon;
use Livewire\Component;

class VerifyUser extends Component
{
    public User $user; // TODO protect against user tampering

    public function verify()
    {
        $this->user->update(['user_verified_at' => Carbon::now()]);
    }

    public function render()
    {
        return view('livewire.verify-user');
    }
}
