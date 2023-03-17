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
                    @if(session('status'))
                        {{ session('status') }}
                    @else
                        @include('components.form', ['form_name' => 'forgot_password_form',
                                                    'form_submit' => 'Request reset link',
                                                    'form_target' => '/forgot-password',
                                                    'form_fields' => [(object)array('type' => 'email', 'name' => 'email', 'required' => true, 'label' => 'Email address', 'error' => 'email')]])
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
