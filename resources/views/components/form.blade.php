@if(in_array('tinymce', array_column($form_fields, 'type')))
    @pushOnce('scripts')
        <script src="{{ asset('js/tinymce/tinymce.min.js') }}" referrerpolicy="origin"></script>
    @endPushOnce
@endif
{{ Form::open(array('url' => $form_target)) }}
    @isset($form_method)
    @method($form_method)
    @endisset
    @foreach ($form_fields as $field)
        @if (is_array($field))
            <div class="container">
                <div class="row">
                    @php
                        $fields = $field
                    @endphp
                    @foreach ($fields as $field)
                    <div class="col ps-0">
                        @include('components.form-field')
                    </div>
                    @endforeach
                </div>
            </div>
        @else
            @include('components.form-field')
        @endif
    @endforeach
    {{ Form::submit($form_submit, ['class' => 'btn btn-primary ' . ($form_submit_classes ?? '')]) }}
{{ Form::close() }}