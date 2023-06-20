<?php

namespace App\Http\Livewire;

use App\Models\Events\Event;
use Carbon\Carbon;
use Livewire\Component;

class EventPrimary extends Component
{
    public Event $event;
    public string $title;
    public string $start;
    public string $end;
    public string $description;
    public string $body;

    public function mount()
    {
        $this->title =       $this->event->title;
        $this->start =       $this->event->start->format('Y-m-d\TH:i');
        $this->end =         $this->event->end->format('Y-m-d\TH:i');
        $this->description = $this->event->description;
        $this->body =        $this->event->body;
    }

    public function submit()
    {
        // TODO XSS resilience
        $this->event->update([
            'title' =>       $this->title,
            'start' =>       new Carbon($this->start),
            'end' =>         new Carbon($this->end),
            'description' => $this->description,
            'body' =>        $this->body
        ]);
    }

    public function render()
    {
        return view('livewire.event-primary');
    }
}
