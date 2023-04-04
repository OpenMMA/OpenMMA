@extends('dashboard.layout')

@pushOnce('scripts')
<script src="{{ asset('/js/dashboard/users.js') }}"></script>
@endPushOnce
@pushOnce('styles')
<link rel="stylesheet" href="{{ asset('/css/dashboard/table.css') }}">
@endPushOnce

@section('dashboard.content')
<div class="border-bottom">
    <h2 class="pt-3 pb-2">Groups</h2>
</div>
<div class="pt-3 px-3">
    <div class="row justify-content-end">
        <div class="col-3">
            @include('components.form', ['form_name' => 'add_group_form',
                                         'form_submit' => 'Create',
                                         'form_target' => '/dashboard/groups/create',
                                         'form_classes' => 'row justify-content-end',
                                         'form_submit_classes' => 'd-inline-block w-auto',
                                         'form_fields' => [
                                            (object)array('type' => 'text', 'name' => 'group_name', 'required' => true, 'placeholder' => 'New group name...', 'class' => 'd-inline-block align-bottom w-50 me-2', 'wrapper' => (object)array('open' => '', 'close' => '')),
                                         ]])
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