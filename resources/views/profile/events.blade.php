@livewireScripts

@extends('profile.layout')

@section('profile.content')
<h2>Events you are registered for</h2>
<hr class="border-secondary">
<div class="container-fluid">
    <div class="row">
        @foreach (['Upcoming events' => $upcoming_events, 'Past events' => $past_events] as $title => $events)
            <h3 class="p-0">{{ $title }}</h3>
            @if (count($events) == 0)
                <div class="alert alert-info">No events found.</div>
            @endif
            @foreach ($events as $event)
            <div class="card mb-3 p-0">
                <div class="d-flex flex-row">
                    <div class="flex-shrink-0 h-100" style="width: 100px;
                                                            background-image:url({{ $event->bannerUrl }});
                                                            background-size: cover;
                                                            background-position: center;
                                                            background-repeat: no-repeat;"></div>
                    <div class="flex-grow-1">
                        <div class="card-body d-flex flex-row">
                            <div class="flex-grow-1">
                                <h5 class="card-title">{{ $event->title }}</h5>
                                <p class="card-text mb-0">{{ $event->description }}</p>
                            </div>
                            <div class="align-self-center flex-shrink-0">
                                <a href="/event/{{ $event->slug }}" class="btn btn-primary mx-2">View event</a>
                                @if (!$event->start->isPast()) 
                                <form action="/event/{{ $event->slug }}/unregister" method="post">
                                    @csrf
                                    <button type="button" class="btn btn-warning mx-2 mt-2" data-bs-toggle="modal" data-bs-target="#confirm-unreg-{{ $event->slug }}">
                                        Unregister
                                    </button>
                                    <div class="modal fade" id="confirm-unreg-{{ $event->slug }}" tabindex="-1">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5">Confirm unregister</h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    Are you sure you want to unregister for the event:<br><b>{{ $event->title }}</b>
                                                    </div>
                                                    <div class="modal-footer d-flex justify-content-center">
                                                        <button type="submit" class="btn btn-danger">Yes</button>
                                                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">No</button>
                                                    </div>
                                                </div>
                                        </div>
                                    </div> 
                                </form>
                                @endif
                            </div>
                        </div>
                        <div class="card-footer text-muted small">
                            <i class="fa fa-calendar"></i> Takes place {{ $event->relativeWhen }}
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        @endforeach
    </div>
</div>
@endsection
