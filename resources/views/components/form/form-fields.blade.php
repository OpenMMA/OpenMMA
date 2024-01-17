@php
    $add_key = $add_key ?? in_array(true, array_map(fn($f) => isset($f->wire), $fields));
@endphp
@foreach ($fields as $field)
    <div @if ($add_key) wire:key="{{ $field->name }}" @endif>
        @if ($field->type == 'select' && $field?->multiple)
            @include('components.form.form-fields.select-multiple', ['field' => $field])
        @else
            @include('components.form.form-fields.' . $field->type, ['field' => $field])
        @endif
    </div>
@endforeach
