@extends('layout.layout')

@section('content')
<div class="d-flex align-items-stretch h-100 overflow-hidden">
    <div class="flex-shrink-0 p-3 bg-light overflow-auto" style="width: 200px;">
        <ul class="nav nav-pills flex-column mb-auto">
            <li class="nav-item"><a href="/dashboard" class="nav-link {{ Request::capture()->path() == 'dashboard' ? 'active' : '' }}">Dashboard</a></li>
            <hr>
            <li class="nav-item"><a href="/dashboard/users" class="nav-link {{ Request::capture()->path() == 'dashboard/users' ? 'active' : '' }}">Users</a></li>
            <hr class="mb-1">
            <p class="small text-muted m-0 px-2">Groups</p>
            @foreach (\App\Models\Groups\Group::inCategory(null) as $group)
                <li class="nav-item"><a href="/dashboard/group/{{ $group->name }}" class="nav-link {{ Request::capture()->path() == 'dashboard/group/'.$group->name  ? 'active' : '' }}">{{ $group->label }}</a></li>
            @endforeach
            <p class="small text-muted m-0 px-2 pt-2">Categories</p>
            @foreach (\App\Models\Groups\GroupCategory::get() as $category)
                <li class="nav-item"><a href="/dashboard/category/{{ $category->name }}" class="nav-link {{ Request::capture()->path() == 'dashboard/category/'.$category->name  ? 'active' : '' }}">{{ $category->label }}</a></li>
            @endforeach
            {{-- <li class="nav-item"><a href="/dashboard/groups" class="nav-link {{ Request::capture()->path() == 'dashboard/groups' ? 'active' : '' }}">Groups</a></li> --}}
            {{-- <li class="nav-item"><a href="/dashboard/roles" class="nav-link {{ Request::capture()->path() == 'dashboard/roles' ? 'active' : '' }}">Roles</a></li> --}}
            <hr>
            <li class="nav-item"><a href="/dashboard/events" class="nav-link {{ Request::capture()->path() == 'dashboard/events' ? 'active' : '' }}">Events</a></li>
            <li class="nav-item"><a href="/dashboard/insights" class="nav-link {{ Request::capture()->path() == 'dashboard/insights' ? 'active' : '' }}">Insights</a></li>
            <hr>
            <li class="nav-item"><a href="/dashboard/system-settings" class="nav-link {{ Request::capture()->path() == 'dashboard/system-settings' ? 'active' : '' }}">System settings</a></li>
        </ul>
    </div>
    <div class="flex-grow-1 overflow-auto p-3">
        @yield('dashboard.content')
    </div>
</div>
@endsection
