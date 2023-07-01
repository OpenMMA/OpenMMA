<nav class="navbar bg-body-secondary border-bottom px-3">
    <a class="navbar-brand fs-3" href="/">
        <img src="{{ url('/img/logo.png') }}" alt="Site logo" style="max-height: 40px;">
        {{ app('settings')['site.name'] }}
    </a>
    <div>
    @auth
    <div class="row">
        <div class="col">
            <p class="fs-5 mb-0 pt-1 text-nowrap">
                Hello, <span id="navbar-first-name">{{ Auth::user()->first_name }}</span>!
            </p>
        </div>
        <div class="col pe-0">
            <a href="/profile" class="btn btn-secondary m-1" role="button">Profile</a>
        </div>
        @if (Auth::user()->can('access_dashboard'))
        <div class="col p-0">
            <a href="/dashboard" class="btn btn-secondary m-1" role="button">Dashboard</a>
        </div>
        @endif
        <div class="col ps-0">
            <form method="POST" action="/logout" class="mb-0">
                @csrf
                <button type="submit" class="btn btn-primary m-1">Logout</button>
            </form>
        </div>
    @endauth
    @guest
    <div>
        {{-- <a href="/register" class="btn btn-secondary m-1" role="button">Register</a>
        <a href="/login" class="btn btn-primary m-1" role="button">Login</a> --}}
    @endguest
    </div>
</nav>