<?php

namespace App\Livewire;

use App\Models\Events\Event;
use App\Models\Groups\Group;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class EventPublishStatus extends Component
{
    public Event $event; // TODO protect against user tampering
    public string $status;
    public string $visibility;

    public function mount()
    {
        $this->status = $this->event->status;
        $this->visibility = $this->event->visibility;
    }

    public function updatingStatus($status)
    {
        if (!Auth::user()->can(Group::find($this->event->group)->name.'.event.publish'))
            return response("Not allowed.", 403);

        if (!in_array($this->status, ['draft', 'published', 'unlisted'])) {
            $this->status = $this->event->status;
            return;
        }
        $this->event->update(['status' => $status]);
    }

    public function updatingVisibility($visibility)
    {
        if (!in_array($this->visibility, ['visible', 'protected', 'local', 'hidden', 'selection'])) {
            $this->visibility = $this->event->visibility;
            return;
        }
        $this->event->update(['visibility' => $visibility]);
    }

    public function render()
    {
        return view('livewire.event-publish-status');
    }
}
