@php
    use Carbon\Carbon;
@endphp
@include('dashboard.header')
@foreach ($events as $event)
<div class="container-fluid">
    <div class="row">
        <div class="card mb-3 p-0" style="max-width: 540px;">
            <div class="row g-0">
                <div class="col-md-4">
                    <img src="{{ $event->bannerUrl }}" class="img-fluid rounded-start">
                </div>
                <div class="col-md-8">
                    <div class="card-body">
                        <h5 class="card-title">{{ $event->title }}</h5>
                        <p class="card-text">{{ $event->description }}</p>
                        <p class="card-text"><small class="text-muted">Takes place {{ $event->relativeWhen }}</small></p>
                        <a href="/event/{{ $event->slug }}/edit" class="btn btn-primary">Edit event</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    @endforeach
@include('dashboard.footer')