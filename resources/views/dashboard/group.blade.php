@php
use App\Models\Groups\Role;
@endphp

@extends('dashboard.layout')

@pushOnce('scripts')
<script src="{{ asset('/js/dashboard/users.js') }}"></script>
@endPushOnce
@pushOnce('styles')
<link rel="stylesheet" href="{{ asset('/css/dashboard/table.css') }}">
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
                @if (Auth::user()->can(['user.view', 'user.assign']))  
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
                @endif
            </div>
            <div>
                @livewire('user-table', ['cols' => ['first_name', 'last_name', 'roles'], 'group' => $group, 'add_remove_button' => true, 'filters' => ['group' => $group->name]])
            </div>
            <h4>Events</h4>
            <div>
                @livewire('event-table', ['group' => $group, 'cols' => ['title', 'start', 'end', 'status']])
            </div>
            <h4>Roles</h4>
            <div class="pb-3">
                <div class="pb-3 container-fluid">
                    <form action="/dashboard/group/{{ $group->name }}/add/role" method="post" class="d-flex">
                        @csrf
                        <div class="col-4">
                            <label class="form-label" for="role_name">Create new role</label>
                            <div class="d-flex">
                                <input type="text" class="form-control" name="role_name" id="role_name" placeholder="Role name...">
                                <button type="submit" class="btn btn-primary text-nowrap ms-2">+ Add role</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div>
                    <table class="table table-striped" id="user_table">
                        <thead>
                            <tr>
                                <th scope="col" width="">Role name</th>
                                <th scope="col" width="1%"></th>
                                <th scope="col" width="1%"></th>
                            </tr>
                        </thead>
                        <tbody class="table-group-divider">
                            @foreach ($roles as $role)
                            <tr>
                                <td>{{ $role->title }}</td>
                                <td class="hide"><a class="btn btn-primary px-1 py-0" href="/dashboard/group/{{ $group->name }}/role/{{ explode('.', $role->name, 2)[1] }}">Edit</a></td>
                                <td class="hide">
                                    @if (!$role->isBaseRole)
                                    @livewire('delete-model', ['model' => $role])
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-4">

        </div>
    </div>
</div>
@endsection