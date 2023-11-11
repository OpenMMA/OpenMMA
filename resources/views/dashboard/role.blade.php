@php
use App\Models\Groups\Permission;
@endphp

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
<h5 class="mb-0 text-muted">Role</h5>
<h2>{{ $role->title }}</h2>
<hr class="border-secondary">
@livewire('role-permissions', ['role' => $role], key(Auth::user()->id))
@endsection