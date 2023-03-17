@php
use Carbon\Carbon;
@endphp

@extends('layout.layout')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-8">
            @if(Session::has('status') && Session::get('status') == 'updated')
            <div class="alert alert-success alert-dismissible fade show position-absolute z-3" role="alert">
                Event updated successfully!
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            @include('components.form', ['form_name' => 'edit_event_form',
                                         'form_method' => 'PUT',
                                         'form_submit' => 'Save changes',
                                         'form_target' => '/event/' . $event->slug . '/edit/body',
                                         'form_fields' => [
                                            (object)array('type' => 'text', 'name' => 'title', 'required' => true, 'default' => $event->title),
                                            array(
                                                (object)array('type' => 'date', 'name' => 'start', 'required' => true, 'label' => 'Start time', 'default' => Carbon::parse($event->start)->format('Y-m-d\TH:i')),
                                                (object)array('type' => 'date', 'name' => 'end', 'required' => true, 'label' => 'End time', 'default' => Carbon::parse($event->end)->format('Y-m-d\TH:i'))
                                            ),
                                            (object)array('type' => 'textarea', 'name' => 'description', 'required' => true, 'rows' => '5', 'label' => 'Description (short)', 'default' => $event->description),
                                            (object)array('type' => 'tinymce', 'name' => 'body', 'required' => true, 'default' => $event->body)
                                        ]])
        </div>
        <div class="col-4">
            <div class="card">
                <div class="card-body">
                    <h4>Set banner</h4>
                    @include('components.form', ['form_name' => 'banner_image_form',
                                                 'form_submit' => 'Upload',
                                                 'form_target' => '/event/' . $event->slug . '/edit/banner',
                                                 'form_fields' => [
                                                    (object)array('type' => 'file', 'name' => 'banner', 'required' => true),
                                                ]])
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <h4>Users can register</h4>
                    @include('components.form', ['form_name' => 'registerable_form',
                                                 'form_submit' => 'Change',
                                                 'form_submit_classes' => 'd-none',
                                                 'form_target' => '/event/' . $event->slug . '/edit/ajax/registerable',
                                                 'form_fields' => [
                                                    (object)array('type' => 'switch', 'name' => 'registerable', 'checked' => $event->registerable,'required' => true),
                                                ]])
                    @include('components.form', ['form_name' => 'enable_comments_form',
                                                'form_classes' => $event->registerable ? '' : 'd-none',
                                                 'form_submit' => 'Change',
                                                 'form_submit_classes' => 'd-none',
                                                 'form_target' => '/event/' . $event->slug . '/edit/ajax/enable_comments',
                                                 'form_fields' => [
                                                    (object)array('type' => 'switch', 'name' => 'enable_comments', 'checked' => $event->enable_comments, 'label' => 'Enable comments'),
                                                ]])
                   @include('components.form', ['form_name' => 'max_registrations_form',
                                                'form_classes' => $event->registerable ? '' : 'd-none',
                                                'method' => 'POST',
                                                'form_submit' => 'Change',
                                                'form_submit_right' => true,
                                                'form_target' => '/event/' . $event->slug . '/edit/max_registrations',
                                                'form_fields' => [
                                                    (object)array('type' => 'number', 'name' => 'max_registrations', 'min' => 0, 'default' => $event->max_registrations, 'label' => 'Max. registrations (0 for no limit)'),
                                                ]])
                    @push('scripts')
                    <script>
                        $('#registerable_form [name=registerable]').change((el) => {
                            $('#registerable_form [name=registerable]').prop('disabled', true);
                            $.ajax({
                                url: $('#registerable_form').attr('action'),
                                method: 'POST',
                                data: {'registerable': el.target.checked},
                            }).done((data) => {
                                if (data.status == 'success') {
                                    if (el.target.checked) {
                                        $('#enable_comments_form').removeClass('d-none');
                                        $('#max_registrations_form').removeClass('d-none');
                                    } else {
                                        $('#enable_comments_form').addClass('d-none');
                                        $('#max_registrations_form').addClass('d-none');
                                    }
                                } else {
                                    alert('Something went wrong!'); // TODO replace with custom alert
                                    el.target.checked = !el.target.checked;
                                }
                                $('#registerable_form [name=registerable]').prop('disabled', false);
                            });
                        });
                        $('#enable_comments_form [name=enable_comments]').change((el) => {
                            $('#enable_comments_form [name=enable_comments]').prop('disabled', true);
                            $.ajax({
                                url: $('#enable_comments_form').attr('action'),
                                method: 'POST',
                                data: {'enable_comments': el.target.checked},
                            }).done((data) => {
                                if (data.status == 'success') {
                                    // pass
                                } else {
                                    alert('Something went wrong!'); // TODO replace with custom alert
                                    el.target.checked = !el.target.checked;
                                }
                                $('#enable_comments_form [name=enable_comments]').prop('disabled', false);
                            });
                        });
                    </script>
                    @endpush
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
