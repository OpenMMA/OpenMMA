@php
use Carbon\Carbon;
use \App\Models\Image;
@endphp

@extends('layout.layout')

@pushOnce('styles')
@livewireStyles
@endPushOnce
@pushOnce('scripts')
@livewireScripts
@endPushOnce

@section('content')

<div class="container">
    <div class="row">
        <div class="col-8 mt-3">
            @livewire('event-primary', ['event' => $event], key($event->id))
        </div>
        <div class="col-4 mt-3">
            <div class="card mb-3">
                <div class="card-body">
                    <h4>Set banner</h4>
                    @if ($event->banner)
                        <img src="{{ Image::find($event->banner)->url }}" class="mx-auto d-block mb-2 rounded shadow-sm" style="max-height: 180px;">
                    @endif
                    <form method="POST" enctype="multipart/form-data" action="/event/{{ $event->slug }}/edit/banner" class="mt-2">
                        @csrf
                        @include('components.form.form-fields.file', ['field' => (object)array('name' => 'banner', 'required' => true)])
                        <button type="submit" class="btn btn-primary">Upload</button>
                    </form>
                </div>
            </div>
            <div class="card mb-3">
                <div class="card-body">
                    @livewire('event-publish-status', ['event' => $event], key($event->id))
                </div>
            </div>
            <div class="card mb-3">
                <div class="card-body">
                    @livewire('event-registration-settings', ['event' => $event], key($event->id))
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
