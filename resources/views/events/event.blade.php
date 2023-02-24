@include('header')
<div class="container">
    <div class="col">
        <h1>{{ $event->title }}</h1>
        {!! $event->body !!}
    </div>
</div>
@include('footer')