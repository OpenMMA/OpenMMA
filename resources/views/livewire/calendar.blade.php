@php
    use Carbon\Carbon;
@endphp

@pushOnce('scripts')
@livewireScripts
@endPushOnce

@pushOnce('styles')
<link href="{{ asset('/css/calendar.css') }}" rel="stylesheet">
@livewireStyles
@endPushOnce

<div>
    <style>
        @foreach ($colors as $color)
        
            .event-c{{$color->id}} {
                border-color: {{$color->primary}};
                background-color: {{$color->secondary}}80;
            }
            .event-c{{$color->id}}.event-hover {
                background-color: {{$color->secondary}}d8;
            }
        @endforeach
    </style>
    <div class="container calendar-container p-3 sticky-top rounded shadow-lg" id="calendar">
        <div class="container text-center">
            <div class="row justify-content-center m-3">
                <div wire:click="updateMonth(-1)" class="col-1" id="cal-prev">
                    <i class="fa-solid fa-angle-left"></i>
                </div>
                <div class="col-3 fs-5 fw-semibold" id="monthyear">
                    {{ $month->format("F Y") }}
                </div>
                <div wire:click="updateMonth(1)" class="col-1" id="cal-next">
                    <i class="fa-solid fa-angle-right"></i>
                </div>
            </div>
            <div class="col-12 border-top border-secondary-subtle"></div>
        </div>
        <div class="calendar-days-header text-center fs-6 text-secondary">
        @foreach ([Carbon::MONDAY, Carbon::TUESDAY, Carbon::WEDNESDAY, Carbon::THURSDAY, Carbon::FRIDAY, Carbon::SATURDAY, Carbon::SUNDAY] as $weekday)
            <div><p class="m-2">{{ strtoupper(Carbon::now()->weekday($weekday)->format("D")) }}</p></div>
        @endforeach
        </div>
        <div class="calendar-days text-secondary">
            @foreach ($calendar_days as $day)
            <div id="day-{{$loop->iteration}}" class="day container p-0 {{ $day->thismonth ? '' : 'inactive' }}" style="z-index: {{42-$loop->iteration}}">
                <span class="{{ $day->today ? 'fw-bold' : 'fw-light' }}">{{ $day->date }}</span>
                @foreach ($day->events as $event_slot)
                    @if ($event_slot)
                    @switch($event_slot->type)
                        @case('single')
                            <a class="event event-c3 event-p{{$loop->iteration}} event-c{{$event_slot->event->color}} event-single" data-blocks="1" event-id="e{{$event_slot->event->id}}" href="{{$event_slot->event->url}}" target="_blank">
                                <p>{{ $event_slot->event->title }}</p>
                                <span class="position-absolute top-0 left-0 w-100 h-100"></span>
                            </a>
                            @break
                            @case('start')
                                <a class="event event-c3 event-p{{$loop->iteration}} event-c{{$event_slot->event->color}} event-start" data-blocks="{{$event_slot->blocks}}" event-id="e{{$event_slot->event->id}}" href="{{$event_slot->event->url}}" target="_blank">
                                    <p>{{ $event_slot->event->title }}</p>
                                    <span class="position-absolute top-0 left-0 w-100 h-100"></span>
                                </a>
                                @break
                            @case('middle')
                                <a class="event event-c3 event-p{{$loop->iteration}} event-c{{$event_slot->event->color}} event-middle" event-id="e{{$event_slot->event->id}}" href="{{$event_slot->event->url}}" target="_blank">
                                    <span class="position-absolute top-0 left-0 w-100 h-100"></span>
                                </a>
                                @break
                            @case('end')
                                <a class="event event-c3 event-p{{$loop->iteration}} event-c{{$event_slot->event->color}} event-end" event-id="e{{$event_slot->event->id}}" href="{{$event_slot->event->url}}" target="_blank">
                                    <span class="position-absolute top-0 left-0 w-100 h-100"></span>
                                </a>
                                @break
                    @endswitch
                    @endif
                @endforeach
            </div>
            @endforeach
        </div>
    </div>
    <script>
    </script>
</div>
