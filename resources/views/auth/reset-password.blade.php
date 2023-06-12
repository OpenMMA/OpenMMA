@extends('layout.layout')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-5 mx-2 p-0 position-relative">

            <div class="card shadow-sm m-4">
                <div class="card-header text-center fs-4">
                    Reset password
                </div>
                <div class="card-body">
                    <form method="POST" action="/reset-password">
                        @csrf
                        @include('components.form.form-fields.email', ['field' => (object)array('name' => 'email', 'required' => true, 'label' => 'Email address')])
                        @include('components.form.form-fields.password', ['field' => (object)array('name' => 'password', 'required' => true, 'label' => 'Password')])
                        @include('components.form.form-fields.password', ['field' => (object)array('name' => 'password_confirmation', 'required' => true, 'label' => 'Password (confirm)')])
                        @include('components.form.form-fields.hidden', ['field' => (object)array('name' => 'token', 'value' => request()->route('token'))])
                        <button type="submit" class="btn btn-primary">Reset password</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
