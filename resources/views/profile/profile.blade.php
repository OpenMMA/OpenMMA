@extends('profile.layout')

@section('profile.content')

@if (!Auth::user()->user_verified)
<div class="my-2">
    <div class="alert alert-warning alert-dismissible fade show w-50 m-auto" role="alert">
        Your account has not yet been approved! Functionality may be limited.
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
</div>
@endif

@if (session('alert-success'))
<div class="w-50 m-auto">
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('alert-success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
</div>
@endif

<h2>Profile</h2>
<hr class="border-secondary">
<div style="max-width: 500px;">
    @livewire('profile.profile')
</div>
@endsection
