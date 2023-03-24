@php
use App\Models\Groups\Role;
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
<div class="border-bottom">
    <h5 class="ps-2 pt-3 mb-0">Group</h5>
    <h2 class="pb-2">{{ $group->label }}</h2>
</div>
<div class="container-fluid">
    <div class="row">
        <div class="col-8">
            <h4>Members</h4>
            <div>
                @livewire('user-table', ['cols' => ['first_name', 'last_name', 'roles'], 'filters' => ['group' => $group->name]])
            </div>
            {{-- <table class="table table-striped" id="user_table">
                <thead>
                    <tr>
                        <th scope="col" width="">Member</th>
                        <th scope="col" width="1%"></th>
                    </tr>
                </thead>
                <tbody class="table-group-divider">
                    @foreach (Role::getGroupMembers($group->name) as $member)
                    <tr>
                        <td>{{ $member->name }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table> --}}
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