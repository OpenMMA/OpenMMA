@extends('layout.layout')

@pushOnce('scripts')
<script src="{{ asset('/js/calendar.js') }}"></script>
@endPushOnce
@pushOnce('styles')
<link href="{{ asset('/css/calendar.css') }}" rel="stylesheet">
@endPushOnce

@section('content')
<div class="container calendar-container p-3 rounded shadow-lg" id="calendar"></div>

<div class="my-5"></div>

@livewire('calendar')

<div style="height: 400px;"></div>
@endsection
