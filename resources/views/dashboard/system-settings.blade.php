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
<div class="pt-2 px-3">
    <ul class="nav nav-tabs px-2 fs-5" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="general-tab" data-bs-toggle="tab" data-bs-target="#general-tab-pane" type="button" role="tab">General</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="registration-tab" data-bs-toggle="tab" data-bs-target="#registration-tab-pane" type="button" role="tab">Registration</button>
        </li>
    </ul>
    <div class="tab-content px-2 pt-3" id="myTabContent">
        <div class="tab-pane fade show active" id="general-tab-pane" role="tabpanel" aria-labelledby="general-tab" tabindex="0">
            @livewire('system-setting-editor', ['label' => 'Site name', 'key' => 'site.name'], key('site.name'))
            @livewire('system-setting-editor', ['label' => 'Site logo', 'key' => 'site.logo'], key('site.logo'))
        </div>
        <div class="tab-pane fade" id="registration-tab-pane" role="tabpanel" aria-labelledby="registration-tab" tabindex="0">
            @livewire('system-setting-editor', ['label' => 'Account custom fields', 'key' => 'account.custom_fields'], key('account.custom_fields'))
            <hr>
            <h4>Import users</h4>
            @livewire('import-users')
        </div>
    </div>
</div>
@endsection