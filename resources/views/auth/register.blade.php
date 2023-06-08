@extends('layout.layout')

@section('content')
<div class="d-flex justify-content-center align-items-center bg-polygons" style="min-height: 100%">
    <div class="card shadow m-4 border-0 flex-grow-1" style="max-width: 500px;">
        <div class="card-header text-center fs-4 border-0">
            Register
        </div>
        <div class="card-body">
            <form method="POST" action="/register">
                @csrf
                @include('components.form.form-fields.text', ['field' => (object)array('name' => 'first_name', 'required' => true, 'label' => 'First name')])
                @include('components.form.form-fields.text', ['field' => (object)array('name' => 'last_name', 'required' => true, 'label' => 'Last name')])
                @include('components.form.form-fields.email', ['field' => (object)array('name' => 'email', 'required' => true, 'label' => 'Email address')])
                @include('components.form.form-fields.password', ['field' => (object)array('name' => 'password', 'required' => true, 'label' => 'Password')])
                @include('components.form.form-fields.password', ['field' => (object)array('name' => 'password_confirmation', 'required' => true, 'label' => 'Password (confirm)')])
                <div class="m-4"></div>
                @include('components.form.form-fields', ['fields' => array_map(fn($v) => (object)$v, setting('account.custom_fields'))])
                <button type="submit" class="btn btn-primary">Register</button>
            </form>
        </div>
    </div>
</div>
@endsection
