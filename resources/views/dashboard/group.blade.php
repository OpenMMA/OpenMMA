@php
use App\Models\Groups\Role;
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
<h5 class="mb-0 text-muted">Group</h5>
<h2>{{ $group->label }}</h2>
<hr class="border-secondary">
<div class="container-fluid">
    <div class="row">
        <div class="col-8">
            <div class="d-flex">
                <h4 class="flex-grow-1">Members</h4>
                <button type="button" class="btn btn-primary mb-2" data-bs-toggle="modal" data-bs-target="#add_user_to_group">+ Add members</button>
                <div class="modal fade" id="add_user_to_group" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5">Add members to {{ $group->label }}</h1>
                            </div>
                            <div class="modal-body mx-3">
                                @livewire('user-table', ['cols' => ['name', 'email'], 'group' => $group, 'add_add_button' => true, 'entries_per_page' => 8, 'disable_entries_per_page' => true, 'filters' => ['notgroup' => $group->name], 'add_view_button' => false])
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div>
                @livewire('user-table', ['cols' => ['first_name', 'last_name', 'roles'], 'group' => $group, 'add_remove_button' => true, 'filters' => ['group' => $group->name]])
            </div>
            <h4>Events</h4>
            <div>
                @livewire('event-table', ['group' => $group, 'cols' => ['title', 'start', 'end', 'status']])
            </div>
            <h4>Roles</h4>
            <div>
                @livewire('role-table', ['group' => $group])
            </div>
        </div>
        <div class="col-4">

        </div>
    </div>
</div>
@endsection