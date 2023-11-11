@extends('dashboard.layout')

@pushOnce('styles')
@livewireStyles
@endPushOnce
@pushOnce('scripts')
@livewireScripts
@endPushOnce

@section('dashboard.content')
<h2>Group Settings</h2>
<hr class="border-secondary">
<div class="pt-2 px-3">
    <div class="pb-3">
        <div class="pb-3 container-fluid">
            <h4>Create new group</h4>
            <form action="/dashboard/group-settings/add/group" method="post" class="d-flex">
                @csrf
                <div class="col-3">
                    <input type="text" class="form-control" name="group_name" placeholder="Group name...">
                </div>
                <button type="submit" class="btn btn-primary text-nowrap ms-2">+ Add group</button>
            </form>
        </div>
        <div class="container-sm m-0">
            <table class="table table-striped b-2" id="user_table">
                <thead>
                    <tr>
                        <th scope="col" width="300px">Group name</th>
                        <th scope="col" width="200px">Group category</th>
                        <th width=""></th>
                        <th scope="col" width="1%"></th>
                    </tr>
                </thead>
                <tbody class="table-group-divider">
                    @foreach ($groups as $group)
                    <tr>
                        <td>{{ $group->label }}</td>
                        <td>@livewire('group-category-select', ['group' => $group])</td>
                        <td></td>
                        <td class="hide"><a href="{{ url("/dashboard/group/$group->name") }}" class="btn btn-primary px-1 py-0">View</a></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            </div>
    </div>

    <hr class="pb-3">

    <div class="pb-3">
        <div class="pb-3 container-fluid">
            <h4>Create new category</h4>
            <form action="/dashboard/group-settings/add/category" method="post" class="d-flex">
                @csrf
                <div class="col-3">
                    <input type="text" class="form-control" name="category_name" placeholder="Category name...">
                </div>
                <button type="submit" class="btn btn-primary text-nowrap ms-2">+ Add category</button>
            </form>
        </div>
        <div class="container-sm m-0">
            <table class="table table-striped" id="user_table">
                <thead>
                    <tr>
                        <th scope="col" width="">Category name</th>
                        <th scope="col" width="1%"></th>
                        <th scope="col" width="1%"></th>
                        <th scope="col" width="1%"></th>
                    </tr>
                </thead>
                <tbody class="table-group-divider">
                    @foreach ($categories as $category)
                    <tr>
                        <td>{{ $category->label }}</td>
                        <td class="hide"><a href="" class="btn btn-primary px-1 py-0">Edit</a></td>
                        <td class="hide"><a href="{{ url("/dashboard/category/$category->name") }}" class="btn btn-primary px-1 py-0">View</a></td>
                        <td class="hide"><a href="" class="btn btn-danger px-1 py-0">Delete</a></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection