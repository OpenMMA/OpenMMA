@extends('layout.layout')

@pushOnce('scripts')
<script src="{{ asset('/js/calendar.js') }}"></script>
@endPushOnce
@pushOnce('styles')
<link href="{{ asset('/css/calendar.css') }}" rel="stylesheet">
@endPushOnce

@section('content')
<div class="container calendar-container p-3 sticky-top rounded shadow-lg" id="calendar"></div>
@endsection
