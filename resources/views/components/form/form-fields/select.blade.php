@extends('components.form.form-field')

@pushOnce('scripts')
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>
@endPushOnce

@pushOnce('styles')
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.bootstrap5.min.css" rel="stylesheet">
@endPushOnce


@section('field-parent-classes')
@overwrite

@section('field')
    <select id="ts-{{ $field->name }}" name="{{ $field->name . ($field->multiple ?? false ? '[]' : '')}}"
            id="{{ $field->name }}"
            class="form-control{{ isset($field->class) ? ' ' . $field->class : '' }}"
            {{ $field->multiple ?? false ? 'multiple' : '' }}
            {{ $field->required ?? false ? 'required' : '' }}
            {!! $field->attributes ?? ''!!}>
        @foreach($field->options as $key => $value)
            <option value="{{ $key }}" {{ $field->value ?? '' == $key ? 'selected' : '' }}>{{ $value }}</option>
        @endforeach
    </select>
    <script>
        new TomSelect('#ts-{{ $field->name }}', {});
    </script>
@overwrite
