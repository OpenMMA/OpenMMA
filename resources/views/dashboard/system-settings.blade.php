@extends('dashboard.layout')

@section('dashboard.content')
<h2>System Settings</h2>
<hr class="border-secondary">
<div class="pt-3 px-3">
    <form method="POST" action="/dashboard/system-settings" class="d-flex align-items-end gap-1">
        @csrf
        <div class="flex-grow-1">
            @include('components.form.form-fields.text', ['field' => (object)array('name' => 'value', 'required' => true, 'label' => 'Site name', 'value' => setting('site.name'))])
            @include('components.form.form-fields.hidden', ['field' => (object)array('name' => 'key', 'value' => 'site.name')])
        </div>
        <div class="flex-shrink-0 mb-3">
            <button type="submit" class="btn btn-primary">Save</button>
        </div>
    </form>
    <form method="POST" action="/dashboard/system-settings" class="d-flex align-items-end gap-1">
        @csrf
        <div class="flex-grow-1">
            {{-- TODO: Fix sanitization removing the json --}}
            @include('components.form.form-fields.textarea', ['field' => (object)array('name' => 'value', 'required' => true, 'label' => 'Account custom fields', 'class' => 'font-monospace', 'value' => json_encode(setting('account.custom_fields'), JSON_PRETTY_PRINT))])
            @include('components.form.form-fields.hidden', ['field' => (object)array('name' => 'key', 'value' => 'account.custom_fields')])
        </div>
        <div class="flex-shrink-0 mb-3">
            <button type="submit" class="btn btn-primary">Save</button>
        </div>
    </form>
</div>
@endsection