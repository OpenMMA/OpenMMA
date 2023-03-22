<?php

namespace App\Http\Livewire;

use App\Models\Events\Event;
use Livewire\Component;

class EventRegistrationSettings extends Component
{
    public Event $event; 
    public bool $registerable;
    public bool $enable_comments;
    public int $max_registrations;

    public function mount()
    {
        $this->registerable = (bool)$this->event->registerable;
        $this->enable_comments = (bool)$this->event->enable_comments;
    }

    public function updatingRegisterable($registerable)
    {
        $this->event->update(['registerable' => $registerable]);
    }

    public function updatingEnableComments($enable_comments)
    {
        $this->event->update(['enable_comments' => $enable_comments]);
    }

    public function setMaxRegistrations()
    {
        $this->event->update(['max_registrations' => $this->max_registrations]);
    }

    public function render()
    {
        return view('livewire.event-registration-settings');
    }
}
