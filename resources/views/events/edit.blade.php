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
            @if(Session::has('status') && Session::get('status') == 'updated')
            <div class="alert alert-success alert-dismissible fade show position-absolute z-3" role="alert">
                Event updated successfully!
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            <form method="PUT" action="/event/{{ $event->slug }}/edit/body">
                @csrf
                @include('components.form.form-fields.text', ['field' => (object)array('name' => 'title', 'required' => true, 'value' => $event->title)])
                <div class="row">
                    <div class="col-6">
                        @include('components.form.form-fields.date', ['field' => (object)array('name' => 'start', 'required' => true, 'label' => 'Start time', 'value' => Carbon::parse($event->start)->format('Y-m-d\TH:i'))])
                    </div>
                    <div class="col-6">
                        @include('components.form.form-fields.date', ['field' => (object)array('name' => 'end', 'required' => true, 'label' => 'End time', 'value' => Carbon::parse($event->end)->format('Y-m-d\TH:i'))])
                    </div>
                </div>
                @include('components.form.form-fields.textarea', ['field' => (object)array('name' => 'description', 'required' => true, 'rows' => 5, 'label' => 'Description (short)', 'value' => $event->description)])
                @include('components.form.form-fields.tinymce', ['field' => (object)array('name' => 'body', 'required' => true, 'value' => $event->body)])
                <button type="submit" class="btn btn-primary">Save changes</button>
            </form>
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
