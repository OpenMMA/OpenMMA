@extends('dashboard.layout')

@pushOnce('scripts')
<script src="{{ asset('/js/dashboard/users.js') }}"></script>
@endPushOnce
@pushOnce('styles')
<link rel="stylesheet" href="{{ asset('/css/dashboard/table.css') }}">
@endPushOnce

@section('dashboard.content')
<h2>Groups</h2>
<hr class="border-secondary">
<div class="pt-3 px-3">
    <div class="row justify-content-end">
        <div class="col-3">
            <form method="POST" action="/dashboard/groups/create" class="row justify-content-end">
                @csrf
                @include('components.form.form-fields.text', ['field' => (object)array('name' => 'group_name', 'required' => true, 'placeholder' => 'New group name...', 'wrapper_classes' => '')])
                <button type="submit" class="btn btn-primary d-inline-block w-auto">Create</button>
            </form>
        </div>
    </div>
    <table class="table table-striped" id="user_table">
        <thead>
            <tr>
                <th scope="col" width="">Group name</th>
                <th scope="col" width="1%"></th>
            </tr>
        </thead>
        <tbody class="table-group-divider">
            @foreach ($groups as $group)
            <tr>
                <td>{{ $group->label }}</td>
                <td class="hide"><a href="{{ url("/dashboard/group/$group->name") }}" class="btn btn-primary px-1 py-0">Edit</a></td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection