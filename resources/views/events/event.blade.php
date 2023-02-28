@include('header')
<div class="container">
    <div class="col">
        <h1>{{ $event->title }}</h1>
        {!! $event->body !!}
    </div>
    <div class="col">
        <a href="/event/{{ $event->slug }}/edit" class="btn btn-primary m-2">Edit event</a>
        @include('components.form', ['form_name' => 'delete_event_form',
                                     'form_submit' => 'Delete event',
                                     'form_target' => '/event/'.$event->slug,
                                     'form_method' => 'delete',
                                     'form_fields' => []])
    </div>
</div>
@include('footer')