<?php

namespace App\Http\Livewire;

use App\Models\Events\Event;
use Carbon\Carbon;
use Livewire\Component;

class Calendar extends Component
{
    public static int $POSITIONS = 3;
    public Carbon $month;

    public function mount()
    {
        $this->month = Carbon::now()->floorMonth();
    }

    public function updateMonth(int $months)
    {
        $this->month->addMonths($months);
    }

    public function render()
    {
        $start = $this->month->copy()->startOfWeek(Carbon::MONDAY);
        $end = $start->copy()->addDays(42);

        $days = [];
        for ($wd = $start->copy(); !$wd->isSameDay($end); $wd->addDay()) {
            array_push($days, (object)['date'      => $wd->format('d'),
                                       'thismonth' => $wd->isSameMonth($this->month),
                                       'today'     => $wd->isSameDay(Carbon::now()),
                                       'events'    => array_fill(0, Calendar::$POSITIONS, null)]);
        }

        $events = Event::where([['start', '>=', $start], ['start', '<=', $end]])
                       ->orWhere([['end', '>=', $start], ['end', '<=', $end]])
                       ->get()->all();

        // Sort events by their duration, from longest to shortest
        usort($events, fn($a, $b) => $b->end->diffInHours($b->start) - $a->end->diffInHours($a->start));

        // "Scheduler" to determine event location in calendar
        foreach ($events as $event) {
            // TODO verify if variables are right way around (start - event->start, not other way around)
            $event_start = $start->diffInDays($event->start, false);
            $event_end = $start->diffInDays($event->end);

            $offset = -1;
            for ($i = 0; $i < Calendar::$POSITIONS && $offset == -1; $i++) {
                $offset = $i;
                for ($j = max(0, $event_start); $j <= min(41, $event_end); $j++) {
                    if ($days[$j]->events[$i] != null) {
                        $offset = -1;
                        break;
                    }
                }
            }

            if ($offset == -1)
                continue;

            if ($event_end - $event_start == 0) {
                $days[$event_start]->events[$offset] = (object)['type' => 'single', 'event' => $event];
            } else {
                for ($i = max(0, $event_start); $i <= min(41, $event_end); $i++) {
                    if ($i == $event_start) {
                        $days[$i]->events[$offset] = (object)['type' => 'start', 'blocks' => $event_end - $event_start + 1, 'event' => $event];
                    } else if ($i == $event_end) {
                        $days[$i]->events[$offset] = (object)['type' => 'end', 'event' => $event];
                    } else {
                        $days[$i]->events[$offset] = (object)['type' => 'middle', 'event' => $event];
                    }
                }
            }
        }

        return view('livewire.calendar', ['calendar_days' => $days, 'events' => $events]);
    }
}
