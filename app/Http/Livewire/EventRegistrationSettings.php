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
    public bool $allow_externals;
    public bool $only_allow_groups;

    public function mount()
    {
        $this->registerable = (bool)$this->event->registerable;
        $this->enable_comments = (bool)$this->event->enable_comments;
        $this->allow_externals = (bool)$this->event->allow_externals;
        $this->only_allow_groups = (bool)$this->event->only_allow_groups;
    }

    public function updating($name, $value)
    {
        switch ($name) {
            case 'registerable':
            case 'enable_comments':
            case 'allow_externals':
            case 'only_allow_groups':
                $this->event->update([$name => $value]);
                break;
        }
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
