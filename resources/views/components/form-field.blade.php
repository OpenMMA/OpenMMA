@if(isset($field->label) && !($field->label_after ?? false))
    {{ Form::label($field->name, $field->label, ['class' => 'form-label']) }}
@endif
@if(isset($field->wrapper))
    {{ $field->wrapper->open }}
@else
    <div class="mb-3 {{ $field->type == 'checkbox' ? 'form-check' : '' }}">
@endif
@switch($field->type)
    @case('hidden')
        {{ Form::hidden($field->name, $field->value) }}
        @break
    @case('text')
        {{ Form::text($field->name, $field->default ?? null, ['class' => 'form-control ' . ($field->class ?? ''), 'required' => $field->required ?? false]) }}
        @break
    @case('email')
        {{ Form::email($field->name, $field->default ?? null, ['class' => 'form-control ' . ($field->class ?? ''), 'required' => $field->required ?? false]) }}
        @break
    @case('password')
        {{ Form::password($field->name, ['class' => 'form-control ' . ($field->class ?? ''), 'required' => $field->required ?? false]) }}
        @break
    @case('date')
        {{ Form::datetimelocal($field->name, $field->default ?? \Carbon\Carbon::now(), ['class' => 'form-control ' . ($field->class ?? ''), 'required' => $field->required ?? false]) }}
        @break
    @case('textarea')
        {{ Form::textarea($field->name, $field->default ?? null, ['class' => 'form-control ' . ($field->class ?? ''), 'rows' => $field->rows ?? '10', 'required' => $field->required ?? false]) }}
        @break
    @case('tinymce')
        @push('scripts')
            <script>
                tinymce.init({
                    selector: 'textarea#{{ $form_name . '-' . $field->name }}', // Replace this CSS selector to match the placeholder element for TinyMCE
                    plugins: 'code table lists',
                    toolbar: 'undo redo | formatselect| bold italic | alignleft aligncenter alignright | indent outdent | bullist numlist | code | table'
                });
            </script>
        @endpush
        {{ Form::textarea($field->name, $field->default ?? null, ['class' => 'form-control ' . ($field->class ?? ''), 'required' => $field->required ?? false, 'id' => $form_name . '-' . $field->name]) }}
        @break
    @case('checkbox')
        {{ Form::checkbox($field->name, $field->name, $field->checked ?? false, ['class' => 'form-check-input ' . ($field->class ?? '')]) }}
        @break
@endswitch
@isset($field->error)
    @if($errors->has($field->error))
        <div class="form-text text-danger">{{ $errors->first($field->error) }}</div>
    @endif
@endisset
@if(isset($field->label) && ($field->label_after ?? false))
    {{ Form::label($field->name, $field->label, ['class' => 'form-label']) }}
@endisset
@if(isset($field->wrapper))
    {{ $field->wrapper->close }}
@else
    </div>
@endif
