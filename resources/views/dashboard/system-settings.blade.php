@extends('dashboard.layout')

@section('dashboard.content')
<div class="border-bottom">
    <h2 class="pt-3 pb-2">System Settings</h2>
</div>
<div class="pt-3 px-3">
    @include('components.form', ['form_name' => 'site_name_form',
                                 'form_submit' => 'Save',
                                 'form_submit_right' => true,
                                 'form_target' => '/dashboard/system-settings',
                                 'form_fields' => [
                                    (object)array('type' => 'text', 'name' => 'value', 'required' => true, 'label' => 'Site name', 'default' => setting('site.name')),
                                    (object)array('type' => 'hidden', 'name' => 'key', 'value' => 'site.name'),
                                 ]])
    @include('components.form', ['form_name' => 'user_custom_fields_form',
                                 'form_submit' => 'Save',
                                 'form_submit_right' => true,
                                 'form_target' => '/dashboard/system-settings',
                                 'form_fields' => [
                                    (object)array('type' => 'textarea', 'name' => 'value', 'required' => true, 'label' => 'Account custom fields', 'class' => 'font-monospace', 'default' => json_encode(setting('account.custom_fields'), JSON_PRETTY_PRINT)),
                                    (object)array('type' => 'hidden', 'name' => 'key', 'value' => 'account.custom_fields'),
                                ]])
</div>
@endsection