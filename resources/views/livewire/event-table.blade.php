@php
    use Carbon\Carbon;
@endphp

<div>
    <ul class="nav nav-tabs px-4 mb-3 d-flex">
        <li class="nav-item">
            <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#event-tab-upcoming" role="tab">Upcoming</button>
        </li>
        <li class="nav-item">
            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#event-tab-past" role="tab">Past</button>
        </li>
        <li class="nav-item ms-auto">
            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#event-tab-create" role="tab">+ New event</button>
        </li>
    </ul>
    <div class="tab-content" id="event_tab_content" style="min-height: 200px;">
        @foreach ($events as $event_list)
        <div class="tab-pane fade {{ $loop->first ? '' : 'show active' }}" id="event-tab-{{ $loop->first ? 'past' : 'upcoming' }}" role="tabpanel">
            <div class="d-flex align-items-start mx-2">
                <div class="flex-grow-1">
                    <input wire:model="query" class="form-control" type="text" placeholder="Search...">
                </div>
            </div>
            <table class="table table-striped lw_table" id="event_table">
                <thead>
                    {{-- TODO fix table column width to be minimal but not less than header width --}}
                    <tr>
                        @foreach($cols as $col => $attrs)
                        <th scope="col">
                            <div>
                                {{ $col_opts[$col]['label'] }}
                                <button wire:click="sortTable('{{ $col }}')" class="btn px-1 py-0">
                                    @switch($attrs['sort_direction'])
                                        @case('asc')
                                            <i class="fa-solid fa-sort-up align-end"></i>
                                            @break
                                        @case('desc')
                                            <i class="fa-solid fa-sort-down align-end"></i>
                                            @break
                                        @default
                                            <i class="fa-solid fa-sort align-end"></i>
                                    @endswitch
                                </button>
                            </div>
                        </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody class="table-group-divider">
                    @foreach ($event_list as $event)
                    <tr>
                        @foreach ($cols as $col => $attrs)
                        <td>
                            @switch($col_opts[$col]['display'])
                                @case('check')
                                    @if($event->$col)
                                        <i class="fa-solid fa-check text-success"></i>
                                        @else
                                        <i class="fa-solid fa-xmark text-danger"></i>
                                        @endif
                                    @break
                                @case('date')
                                    {{ Carbon::parse($event->$col)->format("d-m-Y") }}
                                    @break
                                @case('datetime')
                                    {{ Carbon::parse($event->$col)->format("d-m-Y H:i") }}
                                    @break
                                @case('status')
                                    {{ $event->$col }}
                                    @break
                                @case('val')
                                @default
                                    {{ $event->$col }}
                            @endswitch
                        @endforeach
                        <td class="hide"><a href="{{ url("/event/$event->slug/edit") }}" class="btn btn-primary px-1 py-0">Edit</a></td>
                        <td class="hide"><a href="{{ url("/event/$event->slug") }}" target="_blank" class="btn btn-secondary px-1 py-0">View</a></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="flex-sm-fill d-sm-flex align-items-sm-center justify-content-sm-between">
                <div>
                    <p class="small text-muted">
                        Showing
                        <span class="fw-semibold">{{ $event_list->firstItem() }}</span>
                        to
                        <span class="fw-semibold">{{ $event_list->lastItem() }}</span>
                        {{-- TODO sometimes 'of' dissapears??? --}}
                        of
                        <span class="fw-semibold">{{ $event_list->total() }}</span>
                        results
                    </p>
                </div>
                <div class="d-sm-flex">
                    <div class="d-sm-flex flex-row align-items-start pe-3">
                        <p class="small text-muted text-nowrap pe-2">
                            Items per page:
                        </p>
                        <select wire:model="entries_per_page.{{$loop->index}}" class="form-select form-select-sm">
                            <option value="10">10</option>
                            <option value="25">25</option>
                            <option value="100">100</option>
                        </select>
                    </div>
                    <div>
                        {{ $event_list->links() }}
                    </div>
                </div>
            </div>
        </div>
        @endforeach
        <div class="tab-pane fade" id="event-tab-create" role="tabpanel">
            <h5>Create a new event</h5>
            {{-- NOTE update defer should work but results in NULL for title and description when not typed by hand --}}
            <form wire:submit.prevent="newEvent">
                <label class="form-label mb-1" for="new-event-title">Title</label>
                <input wire:model.lazy="new_event_data.title" class="form-control mb-2" id="new-event-title" type="text" placeholder="Event title..." required>
                <div class="d-flex">
                    <div class="flex-fill mb-2">
                        <label class="form-label mb-1" for="new-event-starttime">Start time</label>
                        <input wire:model.lazy="new_event_data.start" class="form-control" type="datetime-local" name="start" id="new-event-starttime" required>
                    </div>
                    <div class="m-1"></div>
                    <div class="flex-fill mb-2">
                        <label class="form-label mb-1" for="new-event-endtime">End time</label>
                        <input wire:model.lazy="new_event_data.end" class="form-control" type="datetime-local" name="end" id="new-event-endtime" required>
                    </div>
                </div>
                <label class="form-label mb-1" for="description">Description (optional)</label>
                <textarea wire:model.lazy="new_event_data.description" class="form-control" placeholder="Description..." name="description" id="new-event-description"></textarea>
                <input type="submit" class="btn btn-primary my-2" value="Create">
            </form>
        </div>
    </div>
</div>