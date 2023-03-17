@extends('layout.layout')

@section('content')
<div class="container">
    <div class="col-6 offset-3">
        @include('components.form', ['form_name' => 'create_event_form',
                                     'form_submit' => 'Create',
                                     'form_target' => '/event/create',
                                     'form_fields' => [(object)array('type' => 'text', 'name' => 'title', 'required' => true, 'label' => 'Title of new event')]])
    </div>
</div>
@endsection
