@livewireScripts

@extends('profile.layout')

@section('profile.content')
<div class="p-3">
    <h2>Profile</h2>
    <hr class="border-secondary">
    <div style="max-width: 500px;">
        @livewire('profile.profile')
    </div>
</div>
@endsection
