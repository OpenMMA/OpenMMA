@extends('layout.layout')

@section('content')
<div class="d-flex align-items-stretch h-100 overflow-hidden">
    <div class="flex-shrink-0 p-3 bg-light overflow-auto" style="width: 210px;">
        <ul class="nav nav-pills flex-column mb-auto">
            <li class="nav-item">
                <a href="/profile" class="nav-link {{ Request::capture()->path() == 'profile' ? 'active' : '' }}">
                    <i class="fa fa-fw fa-user me-1"></i>
                    Profile
                </a>
            </li>
            <li class="nav-item">
                <a href="/profile/security" class="nav-link {{ Request::capture()->path() == 'profile/security' ? 'active' : '' }}">
                    <i class="fa fa-fw fa-lock me-1"></i>
                    Security
                </a>
            </li>
            <li class="nav-item">
                <a href="/profile/events" class="nav-link {{ Request::capture()->path() == 'profile/events' ? 'active' : '' }}">
                    <i class="fa fa-fw fa-calendar me-1"></i>
                    Events
                </a>
            </li>
            <li class="nav-item">
                <a href="/profile/groups" class="nav-link {{ Request::capture()->path() == 'profile/groups' ? 'active' : '' }}">
                    <i class="fa fa-fw fa-user-group me-1"></i>
                    Groups
                </a>
            </li>
        </ul>
    </div>
    <div class="flex-grow-1 overflow-auto p-3">
        @yield('profile.content')
    </div>
</div>
@endsection
