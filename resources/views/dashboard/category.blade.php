@php
use App\Models\Groups\Group;
use App\Models\Groups\GroupCategory;
@endphp

@extends('dashboard.layout')

@section('dashboard.content')
<div class="border-bottom">
    <h5 class="ps-2 pt-3 mb-0">Category</h5>
    <h2 class="pb-2">{{ $category->label }}</h2>
</div>
<div class="container-fluid">
    <div class="row">
        <div class="col-8">
            <h4>Groups</h4>
            <table class="table table-striped" id="user_table">
                <thead>
                    <tr>
                        <th scope="col" width="">Group</th>
                        {{-- <th scope="col" width="1%"></th> --}}
                    </tr>
                </thead>
                <tbody class="table-group-divider">
                    @foreach (Group::where('category', $category->id)->get() as $group)
                    <tr>
                        <td>{{ $group->label }}</td>
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