@extends('layout.layout')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-5 mx-2 p-0 position-relative">
            @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show position-absolute z-3 w-100" role="alert">
                {{ $errors->first() }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            <div class="card shadow-sm m-4">
                <div class="card-header text-center fs-4">
                    Verify email
                </div>
                <div class="card-body">
                    @if(session('status') == 'verification-link-sent')
                    <p>
                        Verification link sent!
                    </p>
                    @else
                    <p>
                        Thank you for registering!
                        Before you can use your account, please verify your e-mail address.
                        If you did not receive or lost the verification email, you can request a new one:
                    </p>
                    {{ Form::open(array('url' => '/email/verification-notification')) }}
                        {{ Form::submit('Request new verification link', ['class' => 'btn btn-primary col-6 offset-3']) }}
                    {{ Form::close() }}
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
