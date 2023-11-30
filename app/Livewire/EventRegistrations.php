<?php

namespace App\Livewire;

use App\Models\Events\Event;
use App\Models\Events\EventRegistration;
use Livewire\Attributes\Locked;
use Livewire\Component;

class EventRegistrations extends Component
{
    public Event $event;
    #[Locked]
    public $registration_header_int = ['name'    => ['label' => 'Name'],
                                       'email'   => ['label' => 'E-mail address'],
                                       'created' => ['label' => 'Registered at']];
    #[Locked]
    public $registration_header_ext = ['name'     => ['label' => 'Name'],
                                       'email'    => ['label' => 'E-mail address'],
                                       'created'  => ['label' => 'Registered at'],
                                       'verified' => ['label' => 'Verified']];



    public function mount()
    {
        if (!$this->event->registerable || !$this->event->require_additional_data)
            return;
        foreach ($this->event->additional_data_fields as $data_field) {
            $this->registration_header_int += [$data_field['name'] => ['label' => $data_field['label']]];
            $this->registration_header_ext += [$data_field['name'] => ['label' => $data_field['label']]];
        }
    }

    public function render()
    {
        if ($this->event->registerable) {
            $registrations_int = EventRegistration::internal()
                                                  ->where(['event_id' => $this->event->id])
                                                  ->join('users', 'event_registrations.user_id', '=', 'users.id')
                                                  ->get(['users.first_name', 'users.last_name', 'users.email', 'event_registrations.data', 'event_registrations.created_at AS created']);
            $registrations_ext = $this->event->allow_externals ? EventRegistration::external()
                                                                                  ->where(['event_id' => $this->event->id])
                                                                                  ->join('externals', 'event_registrations.external_id', '=', 'externals.id')
                                                                                  ->get(['externals.name', 'externals.email', 'externals.email_verified_at AS verified', 'event_registrations.data', 'event_registrations.created_at AS created'])
                                                               : [];
        } else {
            $registrations_int = [];
            $registrations_ext = [];
        }
        // dd($registrations_int, $registrations_ext);
        return view('livewire.event-registrations', ['registrations_int' => $registrations_int, 'registrations_ext' => $registrations_ext]);
    }
}
