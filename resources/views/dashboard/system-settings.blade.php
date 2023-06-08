@extends('dashboard.layout')

@pushOnce('styles')
@livewireStyles
@endPushOnce
@pushOnce('scripts')
@livewireScripts
@endPushOnce

@section('dashboard.content')
<h2>System Settings</h2>
<hr class="border-secondary">
<div class="pt-3 px-3">
    @livewire('system-setting-editor', ['label' => 'Site name', 'key' => 'site.name'], key('site.name'))
    @livewire('system-setting-editor', ['label' => 'Site logo', 'key' => 'site.logo'], key('site.logo'))
    @livewire('system-setting-editor', ['label' => 'Account custom fields', 'key' => 'account.custom_fields'], key('account.custom_fields'))
    @livewire('system-setting-editor', ['label' => 'Test number', 'key' => 'test.num'], key('test.num'))
</div>
@endsection