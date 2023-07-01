@extends('layout.layout')

@pushOnce('scripts')
<script src="{{ asset('/js/calendar.js') }}"></script>
@endPushOnce
@pushOnce('styles')
<link href="{{ asset('/css/calendar.css') }}" rel="stylesheet">
@endPushOnce

@section('content')

@guest
<div class="my-2">
    <div class="alert alert-warning alert-dismissible fade show w-50 m-auto" role="alert">
        <strong>You are not logged in!</strong> This means you may not be able to see all planned activities.
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
</div>
@endguest
@auth
@if (!Auth::user()?->user_verified)
<div class=" my-2">
    <div class="alert alert-warning alert-dismissible fade show w-50 m-auto" role="alert">
        Your account has not yet been approved! Functionality may be limited.
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
</div>
@endif
@endauth

@livewire('calendar')

<div style="height: 400px;"></div>
@endsection
