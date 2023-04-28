@extends('layout.layout')

@section('content')
<div class="d-flex justify-content-center align-items-center bg-polygons" style="min-height: 100%">
    <div class="card shadow m-4 border-0 flex-grow-1" style="max-width: 500px;">
        <div class="card-header text-center fs-4 border-0">
            Register
        </div>
        <div class="card-body">
            @include('components.form', ['form_name' => 'register_form',
                                            'form_submit' => 'Register',
                                            'form_target' => '/register',
                                            'form_fields' => array_merge([
                                            (object)array('type' => 'text', 'name' => 'first_name', 'required' => true, 'label' => 'First name', 'error' => 'first_name'),
                                            (object)array('type' => 'text', 'name' => 'last_name', 'required' => true, 'label' => 'Last name', 'error' => 'last_name'),
                                            (object)array('type' => 'email', 'name' => 'email', 'required' => true, 'label' => 'Email address', 'error' => 'email'),
                                            (object)array('type' => 'password', 'name' => 'password', 'required' => true, 'label' => 'Password', 'error' => 'password'),
                                            (object)array('type' => 'password', 'name' => 'password_confirmation', 'required' => true, 'label' => 'Password (confirm)'),
                                            (object)array('type' => 'divider', 'class' => 'm-4'),
                                        ], array_map(fn($v) => (object)$v, setting('account.custom_fields'))
                                        )])
        </div>
    </div>
</div>
@endsection
