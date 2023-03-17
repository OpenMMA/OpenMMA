@extends('layout.layout')

@section('content')
<div class="container">
    <div class="row">
        <h1>{{ $event->title }}</h1>
        <p><small>{{ $event->relativeWhen }}</small></p>
        <div class="col-9">
            {!! $event->body !!}
            <div class="card mt-3">
                <div class="card-body">
                    @if ($event->registerable == 1)
                    <h4>Register for this event</h4>
                    @guest
                        <p>You need to be logged in to register.</p>
                    @endguest
                    @auth
                    @if(\App\Models\EventRegistration::userRegistrationForEvent(Auth::id(), $event->id))
                        <p>You have registered for this event!</p>
                    @else
                    @include('components.form', ['form_name' => 'register_event_form',
                                                 'form_submit' => 'Register',
                                                 'form_submit_classes' => 'btn-primary',
                                                 'form_target' => '/event/'.$event->slug.'/register',
                                                 'form_method' => 'post',
                                                 'form_fields' => $event->enable_comments ? [(object)array('type' => 'textarea', 'name' => 'comment', 'rows' => 4, 'label' => 'Please enter additional information:')] : []])
                    @endif
                    @endauth
                    @else
                    <h4>Registering for this event is not possible.</h4>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-3">
            <img src="{{ $event->bannerUrl }}" class="img-fluid">
        </div>
    </div>
    <div class="row">
        <div class="col">
            <a href="/event/{{ $event->slug }}/edit" class="btn btn-primary my-2">Edit event</a>
            @include('components.form', ['form_name' => 'delete_event_form',
                                         'form_submit' => 'Delete event',
                                         'form_submit_classes' => 'btn-danger',
                                         'form_target' => '/event/'.$event->slug,
                                         'form_method' => 'delete',
                                         'form_fields' => []])
        </div>
    </div>
</div>
@endsection
