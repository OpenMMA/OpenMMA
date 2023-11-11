@php
use App\Models\Groups\Group;
use App\Models\Groups\GroupCategory;
@endphp

@extends('dashboard.layout')

@section('dashboard.content')
<h5 class="mb-0 text-muted">Category</h5>
<h2>{{ $category->label }}</h2>
<hr class="border-secondary">
<div class="container-fluid">
    <div class="row">
        <div class="col-8">
            <h4>Groups</h4>
            <table class="table table-striped" id="user_table">
                <thead>
                    <tr>
                        <th scope="col" width="">Group</th>
                        <th scope="col" width="1%"></th>
                    </tr>
                </thead>
                <tbody class="table-group-divider">
                    @foreach (Group::where('category', $category->id)->get() as $group)
                    <tr>
                        <td>{{ $group->label }}</td>
                        <td class="hide"><a href="{{ url("/dashboard/group/$group->name") }}" class="btn btn-primary px-1 py-0">Edit</a></td>
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