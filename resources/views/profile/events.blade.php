@livewireScripts

@extends('profile.layout')

@section('profile.content')
<h2>Events you are registered for</h2>
<hr class="border-secondary">
<div class="container-fluid">
    <div class="row">
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
                        </div>
                    </div>
                    <div class="card-footer text-muted small">
                        <i class="fa fa-calendar"></i> Takes place {{ $event->relativeWhen }}
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
