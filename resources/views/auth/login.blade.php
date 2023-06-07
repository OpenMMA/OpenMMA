@extends('layout.layout')

@php
    // Store the previous url to redirect back to
    session()->put('url.intended', url()->previous());
@endphp

@section('content')
<div class="d-flex justify-content-center align-items-center bg-polygons" style="min-height: 100%">
    <div class="card shadow m-4 border-0 flex-grow-1" style="max-width: 500px;">
        @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show position-absolute z-3 w-100" role="alert">
            {{ $errors->first() }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
        <div class="card-header text-center border-0 fs-4">
            Login
        </div>
        <div class="card-body">
            <form method="POST" action="/login">
                @csrf
                @include('components.form.form-fields.email', ['field' => (object)array('name' => 'email', 'required' => true, 'label' => 'Email address')])
                @include('components.form.form-fields.password', ['field' => (object)array('name' => 'password', 'required' => true, 'label' => 'Password')])
                @include('components.form.form-fields.check', ['field' => (object)array('name' => 'remember', 'label' => 'Remember me', 'label_after' => true)])
                <button type="submit" class="btn btn-primary">Login</button>
            </form>
        <div class="ms-1 mt-2">
            <a href="/register">Register</a>
            <br>
            <a href="/forgot-password">Forgot password?</a>
        </div>
        </div>
    </div>
</div>
@endsection
