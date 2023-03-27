@php
use App\Models\Groups\Permission;
@endphp

@extends('dashboard.layout')

@pushOnce('scripts')
<script src="{{ asset('/js/dashboard/users.js') }}"></script>
@livewireStyles
@endPushOnce
@pushOnce('styles')
<link rel="stylesheet" href="{{ asset('/css/dashboard/users.css') }}">
@livewireScripts
@endPushOnce

@section('dashboard.content')
<h2>Role: {{ $role->title }}</h2>
@livewire('role-permissions', ['role' => $role], key($user->id))
@endsection