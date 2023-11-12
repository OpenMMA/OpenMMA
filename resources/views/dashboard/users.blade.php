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
<h2>Users</h2>
<hr class="border-secondary">
<div class="pt-3 px-3">
    @livewire('user-table', ['add_view_button' => true, 'cols' => ['first_name', 'last_name', 'email', 'email_verified_at', 'created_at', 'groups', 'user_verified_at']], key('ut'))
</div>
@endsection
