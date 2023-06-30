<?php

namespace App\Http\Livewire;

use App\Models\Events\Event;
use Livewire\Component;

class EventRegistrationSettings extends Component
{
    public Event $event; // TODO protect against user tampering
    public bool $registerable;
    public bool $require_additional_data;
    public string $additional_data_fields;
    public $max_registrations;  // No data type, as value from <input> is always of type string.
    public bool $queueable;
    public bool $allow_externals;
    public bool $only_allow_groups;

    public function mount()
    {
        $this->registerable = (bool)$this->event->registerable;
        $this->require_additional_data = (bool)$this->event->require_additional_data;
        $this->additional_data_fields = json_encode($this->event->additional_data_fields);
        $this->max_registrations = $this->event->max_registrations;
        $this->queueable = (bool)$this->event->queueable;
        $this->allow_externals = (bool)$this->event->allow_externals;
        $this->only_allow_groups = (bool)$this->event->only_allow_groups;
    }

    public function updating($name, $value)
    {
        switch ($name) {
            case 'registerable':
            case 'require_additional_data':
            case 'allow_externals':
            case 'queueable':
            case 'only_allow_groups':
                $this->event->update([$name => $value]);
                break;
        }
    }

    public function setAdditionalDataFields()
    {
        // TODO verify valid json
        $this->event->update(['additional_data_fields' => json_decode($this->additional_data_fields)]);
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
