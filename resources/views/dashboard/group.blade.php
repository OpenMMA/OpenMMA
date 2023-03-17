@php
use App\Models\Role;
@endphp

@extends('dashboard.layout')

@section('dashboard.content')
<div class="border-bottom">
    <h5 class="ps-2 pt-3 mb-0">Group</h5>
    <h2 class="pb-2">{{ $group->title }}</h2>
</div>
<div class="container-fluid">
    <div class="row">
        <div class="col-8">
            <h4>Roles</h4>
            <table class="table table-striped" id="user_table">
                <thead>
                    <tr>
                        <th scope="col" width="">Member</th>
                        {{-- <th scope="col" width="1%"></th> --}}
                    </tr>
                </thead>
                <tbody class="table-group-divider">
                    @foreach (Role::getGroupMembers($group->name) as $member)
                    <tr>
                        <td>{{ $member->name }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <h4>Roles</h4>
            <table class="table table-striped" id="user_table">
                <thead>
                    <tr>
                        <th scope="col" width="">Role name</th>
                        {{-- <th scope="col" width="1%"></th> --}}
                    </tr>
                </thead>
                <tbody class="table-group-divider">
                    @foreach (Role::getGroup($group->name) as $role)
                    <tr>
                        <td>{{ $role->title }}</td>
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