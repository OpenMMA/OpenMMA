<?php

namespace App\Http\Livewire;

use App\Mail\ExternalVerify;
use App\Models\Events\Event;
use App\Models\External;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\URL;
use Livewire\Component;

class EventRegistration extends Component
{
    public Event $event;
    public array $additional_data = [];
    public array $external = [];
    public bool $registered = false;

    public function mount()
    {
        // $this->additional_data = ['alcohol' => 'no', 'allergies' => ''];
    }

    public function register()
    {
        if (!$this->event->registerable)
            return;

        // Not logged in, no externals allowed. Cannot register.
        if (!Auth::check() && !$this->event->allow_externals)
            return;

        // dd($this->additional_data, $this->external);
        if ($this->event->require_additional_data) {
            $keys = array_map(fn($f) => $f['name'], $this->event->additional_data_fields);
            $data = array_combine($keys, array_map(fn($k) => $this->additional_data[$k] ?? '', $keys));
        } else {
            $data = [];
        }

        if (!Auth::check()) {
            $external = External::create(['name' => $this->external['name'],
                                          'email' => $this->external['email'],
                                          'affiliation' => $this->external['affiliation'] ?? null]);
            \App\Models\Events\EventRegistration::create(['external_id' => $external->id, 'event_id' => $this->event->id, 'data' => json_encode($data)]);
            $link = URL::temporarySignedRoute(
                'external-verification.verify',
                Carbon::now()->addMinutes(60*24),
                [
                    'id' => $external->id,
                    'hash' => sha1($external->email),
                ]
            );
            Mail::to($external->email)->send(new ExternalVerify($external, $this->event, $link));
        } else {
            \App\Models\Events\EventRegistration::create(['user_id' => Auth::user()->id, 'event_id' => $this->event->id, 'data' => json_encode($data)]);
        }
        $this->registered = true;

    }

    public function render()
    {
        return view('livewire.event-registration');
    }
}
