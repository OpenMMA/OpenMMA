@extends('dashboard.layout')

@pushOnce('scripts')
<script src="{{ asset('/js/dashboard/users.js') }}"></script>
@livewireStyles
@endPushOnce
@pushOnce('styles')
<link rel="stylesheet" href="{{ asset('/css/dashboard/table.css') }}">
@livewireScripts
@endPushOnce

@section('dashboard.content')
<div class="border-bottom">
    <h2 class="pt-3 pb-2">Users</h2>
</div>
<div class="pt-3 px-3">
    @livewire('user-table', ['cols' => ['first_name', 'last_name', 'email', 'email_verified_at', 'created_at', 'groups', 'user_verified_at']])
</div>
@endsection
