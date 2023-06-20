@extends('layout.layout')

@section('content')
<div class="d-flex flex-column h-100 overflow-hidden">
    @if (Auth::user()?->can($event->group_name.'.event.edit'))
    <div class="bg-light border-bottom d-flex flex-row ps-3">
        <div class="flex-grow-1 align-self-center">
            <i class="fa fa-eye"></i>
            {{-- TODO: Use interface labels here instead of system internal ones --}}
            {{ $event->status }} - {{ $event->visibility }}
        </div>
        <a href="/event/{{ $event->slug }}/edit" class="btn btn-primary rounded-0 flex-shrink-0 h-100">Edit event</a>
        {{-- TODO: Fix --}}
        <form method="DELETE" action="/event/{{ $event->slug }}">
            @csrf
            <button type="submit" class="btn btn-danger rounded-0 flex-shrink-0 h-100">Delete event</button>
        </form>
    </div>
    @endif
    <div class="flex-grow-1 overflow-auto">
        <div class="container py-3">
            <h1>{{ $event->title }}</h1>
            <p><small><i class="fa fa-calendar pe-1"></i> {{ $event->timeRange }}</small></p>
            <div class="row">
                <div class="col-12 col-md-4 col-lg-3 pb-3">
                    <img src="{{ $event->bannerUrl }}" class="img-fluid rounded-2">
                </div>
                <div class="col-12 col-md-8 col-lg-6 pb-3">
                    {!! $event->body !!}
                </div>
                <div class="col-12 col-md-12 col-lg-3 pb-3">
                    <div class="card">
                        @if ($event->registerable == 1)
                        <div class="card-header">
                            Register for this event
                        </div>
                        @guest
                        <div class="card-body bg-primary-subtle text-primary">
                            You need to be logged in to register.
                        </div>
                        @endguest
                        @auth
                        @if(\App\Models\Events\EventRegistration::userRegistrationForEvent(Auth::id(), $event->id))
                        <div class="card-body bg-success-subtle text-success">
                            You have registered for this event!
                        </div>
                        @else
                        <div class="card-body">
                            <form method="POST" action="/event/{{ $event->slug }}/register">
                                @csrf
                                @if ($event->enable_comments)
                                    @include('components.form.form-fields.textarea', ['field' => (object)array('name' => 'comment', 'rows' => 4, 'label' => 'Please enter additional information:')])
                                @endif
                                <button type="submit" class="btn btn-primary">Register</button>
                            </form>
                        </div>
                        @endif
                        @endauth
                        @else
                        <div class="card-header">
                            Registering for this event is not possible.
                        </div>
                        @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
