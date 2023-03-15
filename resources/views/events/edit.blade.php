@php
use Carbon\Carbon;
@endphp
@include('header')
<div class="container">
    <div class="row">
    </div>
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
        <h4>Set banner</h4>
        @include('components.form', ['form_name' => 'banner_image_form',
                                     'form_submit' => 'Upload',
                                     'form_target' => '/event/' . $event->slug . '/edit/banner',
                                     'form_fields' => [
                                        (object)array('type' => 'file', 'name' => 'banner', 'required' => true),
                                    ]])
        </div>
    </div>
</div>
@include('footer')