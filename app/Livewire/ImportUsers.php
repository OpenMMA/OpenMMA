<?php

namespace App\Livewire;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;

class ImportUsers extends Component
{
    use WithFileUploads;
 
    #[Rule('required|mimes:csv,txt')]
    public $user_file;

    public function save()
    {
        if (!isset($this->user_file))
            return;

        $data = array_map(fn($n) => str_getcsv($n, ';'), file($this->user_file->path()));
        $keys = array_flip(array_shift($data));
        $field_idx = array_map(fn($f) => $keys[$f], ['firstname', 'infix', 'lastname', 'email']);
        
        $custom_fields = array_filter(array_map(fn($f) => $f->name, setting('account.custom_fields')), fn($f) => array_key_exists($f, $keys));
        
        foreach ($data as $user) {
            if (User::where('email', $user[$keys['email']])->first() != null)
                continue;

            $custom_data = array_combine($custom_fields, array_map(fn($f) => $user[$keys[$f]], $custom_fields));
            $duser = User::create(['first_name'  => $user[$keys['firstname']],
                                   'last_name'   => ($user[$keys['infix']] != '') ? $user[$keys['infix']] . ' ' . $user[$keys['lastname']] : $user[$keys['lastname']],
                                   'email'       => $user[$keys['email']],
                                   'custom_data' => $custom_data,
                                   'password'    => Hash::make(bin2hex(random_bytes(32))),
                                   'user_verified_at' => Carbon::now()]);
            $duser->markEmailAsVerified();
            DB::table('users')->where(['id' => $duser->id, 'email' => $duser->email])->update(['created_at' => Carbon::parse($user[$keys['Datum toegevoegd']])]);
            $duser->assignRole('members.');
        }

        session()->flash('status', 'Non-existing users imported!');
    }

    public function render()
    {
        return view('livewire.import-users');
    }
}
