<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>OpenCDX</title>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
        <link rel="stylesheet" href="{{ asset('/fontawesome/css/fontawesome.css') }}">
        <link rel="stylesheet" href="{{ asset('/fontawesome/css/solid.css') }}">

        <link href="{{ asset('/css/app.css') }}" rel="stylesheet">
        <script src="{{ asset('/js/app.js') }}"></script>
    </head>
    <body>
        <header class="navbar sticky-top bg-dark p-0 shadow">
            <a class="col-2 text-light fs-3 text-decoration-none me-0 px-3 py-2">Eureka!</a>
        </header>
        <div class="container-fluid">
            <div class="row">
                <nav class="col-2 position-fixed top-0 bottom-0 start-0 pt-5 d-block bg-light border-end">
                    <div class="position-sticky pt-4">
                        <ul class="nav flex-column">
                            <li class="nav-item"><a href="/dashboard" class="nav-link">Dashboard</a></li>
                            <hr>
                            <li class="nav-item"><a href="/dashboard/users" class="nav-link">Users</a></li>
                            <li class="nav-item"><a href="/dashboard/groups" class="nav-link">Groups</a></li>
                            <li class="nav-item"><a href="/dashboard/roles" class="nav-link">Roles</a></li>
                            <hr>
                            <li class="nav-item"><a href="/dashboard/events" class="nav-link">Events</a></li>
                            <li class="nav-item"><a href="/dashboard/insights" class="nav-link">Insights</a></li>
                            <hr>
                            <li class="nav-item"><a href="/dashboard/settings" class="nav-link">System settings</a></li>
                        </ul>
                    </div>
                </nav>  
                <div class="col-10 px-5 ms-auto">            
