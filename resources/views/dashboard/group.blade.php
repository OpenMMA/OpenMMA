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
<div class="border-bottom">
    <h5 class="ps-2 pt-3 mb-0">Group</h5>
    <h2 class="pb-2">{{ $group->label }}</h2>
</div>
<div class="container-fluid">
    <div class="row">
        <div class="col-8">
            <div>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add_user_to_group">+ Add members</button>
                <div class="modal fade" id="add_user_to_group" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5">Add members to {{ $group->label }}</h1>
                            </div>
                            <div class="modal-body mx-3">
                                @livewire('user-table', ['cols' => ['name', 'email', 'add_to_group'], 'group' => $group, 'entries_per_page' => 8, 'disable_entries_per_page' => true, 'filters' => ['notgroup' => $group->name], 'add_view_button' => false])
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <h4>Members</h4>
            <div>
                @livewire('user-table', ['cols' => ['first_name', 'last_name', 'roles', 'remove_from_group'], 'group' => $group, 'filters' => ['group' => $group->name]])
            </div>
            <h4>Events</h4>
            <div>
                @livewire('event-table', ['group' => $group, 'cols' => ['title', 'start', 'end', 'status']])
            </div>
            <h4>Roles</h4>
            <table class="table table-striped" id="user_table">
                <thead>
                    <tr>
                        <th scope="col" width="">Role name</th>
                        <th scope="col" width="1%"></th>
                    </tr>
                </thead>
                <tbody class="table-group-divider">
                    @foreach (Role::getGroupRoles($group->name) as $role)
                    <tr>
                        <td>{{ $role->title }}</td>
                        <td><a href="/dashboard/group/{{ $group->name }}/role/{{ explode('.', $role->name, 2)[1] }}">link</a></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="col-4">

        </div>
    </div>
</div>
@endsection