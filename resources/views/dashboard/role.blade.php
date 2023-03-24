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
{{-- {{ json_encode(Permission::getPermissionsForGroup($group)) }} --}}
    @livewire('role-permissions', ['role' => $role, 'group' => $group], key($user->id))
@endsection