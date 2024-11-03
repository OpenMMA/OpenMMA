@extends('layout.layout')

@section('content')
<div class="d-flex align-items-stretch h-100 overflow-hidden">
    <div class="flex-shrink-0 p-3 bg-light overflow-auto" style="width: 210px;">
        <ul class="nav nav-pills flex-column mb-auto">
            <li class="nav-item">
                <a href="/dashboard" class="nav-link {{ Request::capture()->path() == 'dashboard' ? 'active' : '' }}">
                    <i class="fa fa-fw fa-diagram-project me-1"></i>
                    Dashboard
                </a>
            </li>
            <hr>
            <li class="nav-item">
                <a href="/dashboard/users" class="nav-link {{ Request::capture()->path() == 'dashboard/users' ? 'active' : '' }}">
                    <i class="fa fa-fw fa-table-list me-1"></i>
                    Users
                </a>
            </li>
            <hr class="mb-1">
            <p class="small text-muted m-0 px-2 pt-2 pb-2">Groups</p>
            @foreach (\App\Models\Groups\Group::inCategory(null) as $group)
                <li class="nav-item">
                    <a href="/dashboard/group/{{ $group->name }}" class="nav-link {{ Request::capture()->path() == 'dashboard/group/'.$group->name  ? 'active' : '' }}">
                        <i class="fa fa-fw fa-user-group me-1"></i>
                        {{ $group->label }}
                    </a>
                </li>
            @endforeach
            <p class="small text-muted m-0 px-2 pt-3 pb-2">Group categories</p>
            @foreach (\App\Models\Groups\GroupCategory::get() as $category)
                <li class="nav-item">
                    <a href="/dashboard/category/{{ $category->name }}" class="nav-link {{ Request::capture()->path() == 'dashboard/category/'.$category->name  ? 'active' : '' }}">
                        <i class="fa fa-fw fa-folder me-1"></i>
                        {{ $category->label }}
                    </a>
                </li>
            @endforeach
            {{-- <li class="nav-item"><a href="/dashboard/groups" class="nav-link {{ Request::capture()->path() == 'dashboard/groups' ? 'active' : '' }}">Groups</a></li> --}}
            {{-- <li class="nav-item"><a href="/dashboard/roles" class="nav-link {{ Request::capture()->path() == 'dashboard/roles' ? 'active' : '' }}">Roles</a></li> --}}
            <hr>
            <li class="nav-item">
                <a href="/dashboard/events" class="nav-link {{ Request::capture()->path() == 'dashboard/events' ? 'active' : '' }}">
                    <i class="fa fa-fw fa-calendar me-1"></i>
                    Events
                </a>
            </li>
            <li class="nav-item">
                <a href="/dashboard/insights" class="nav-link {{ Request::capture()->path() == 'dashboard/insights' ? 'active' : '' }}">
                    <i class="fa fa-fw fa-chart-bar me-1"></i>
                    Insights
                </a>
            </li>
            <hr>
            <li class="nav-item">
                <a href="/dashboard/system-settings" class="nav-link {{ Request::capture()->path() == 'dashboard/system-settings' ? 'active' : '' }}">
                    <i class="fa fa-fw fa-cog me-1"></i>
                    System settings
                </a>
            </li>
            <li class="nav-item">
                <a href="/dashboard/group-settings" class="nav-link {{ Request::capture()->path() == 'dashboard/group-settings' ? 'active' : '' }}">
                    <i class="fa fa-fw fa-users-rectangle me-1"></i>
                    Group settings
                </a>
            </li>
        </ul>
    </div>
    <div class="flex-grow-1 overflow-auto p-3">
        @yield('dashboard.content')
    </div>
</div>
@endsection
