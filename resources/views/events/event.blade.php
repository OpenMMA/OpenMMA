@include('header')
<div class="container">
    <div class="row">
        <h1>{{ $event->title }}</h1>
        <p><small>{{ $event->relativeWhen }}</small></p>
        <div class="col-9">
            {!! $event->body !!}
        </div>
        <div class="col-3">
            <img src="{{ $event->bannerUrl }}" class="img-fluid">
        </div>
    </div>
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
@include('footer')