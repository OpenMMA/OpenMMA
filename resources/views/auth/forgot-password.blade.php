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
                        <form method="POST" action="/forgot-password">
                            @csrf
                            @include('components.form-fields.email', ['field' => (object)array('name' => 'email', 'required' => true, 'label' => 'Email address')])
                            <button type="submit" class="btn btn-primary">Request reset link</button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
