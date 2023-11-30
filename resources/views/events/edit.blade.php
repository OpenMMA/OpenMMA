@php
use Carbon\Carbon;
use \App\Models\Image;
@endphp

@extends('layout.layout')

@section('content')

<div class="container mb-5">
    <h2 class="mt-4">Content</h2>
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
    @if (Auth::user()->can(App\Models\Groups\Group::find($event->group)->name.'.registration.view'))
    <hr class="my-4">
    <h2 class="my-4">Registrations</h2>
    <div class="row">
        @livewire('event-registrations', ['event' => $event])
    </div>
    @endif
</div>
@endsection
