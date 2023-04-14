@extends('layout.layout')

@section('content')
<div class="container">
    <div class="col-6 offset-3">
        <form method="POST" action="/event/create">
            @csrf
            @include('components.form.form-fields.text', ['field' => (object)array('name' => 'title', 'required' => true, 'label' => 'Title of new event')])
            <button type="submit" class="btn btn-primary">Create</button>
        </form>
    </div>
</div>
@endsection
