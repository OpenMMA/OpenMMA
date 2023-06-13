@extends('layout.layout')

@pushOnce('scripts')
<script src="{{ asset('/js/calendar.js') }}"></script>
@endPushOnce
@pushOnce('styles')
<link href="{{ asset('/css/calendar.css') }}" rel="stylesheet">
@endPushOnce

@section('content')

@livewire('calendar')

<div style="height: 400px;"></div>
@endsection
