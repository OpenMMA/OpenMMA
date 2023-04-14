@extends('components.form.form-field')

@pushOnce('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.4/js/select2.min.js"></script>
@endPushOnce
@push('scripts')
    <script>
        $(document).ready(() => {$("#{{ $field->name }}").select2({
            closeOnSelect : false,
            allowHtml: true,
            allowClear: true,
        })});
    </script>
@endpush

@pushOnce('styles')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.4/css/select2.min.css" rel="stylesheet" />
    <style>
        /* TEMPORARY FIX */
        .select2-selection {
            border: var(--bs-border-width) solid var(--bs-border-color) !important;
            border-radius: .375rem !important;
            padding: 1px 7px;
        }
        .select2-dropdown {
            border: var(--bs-border-width) solid var(--bs-border-color) !important;
        }
    </style>
@endPushOnce


@section('field-parent-classes')
@overwrite

@section('field')
    <select name="{{ $field->name . ($field->multiple ?? false ? '[]' : '')}}"
            id="{{ $field->name }}"
            class="form-control{{ isset($field->class) ? ' ' . $field->class : '' }}"
            {{ $field->multiple ?? false ? 'multiple' : '' }}
            {{ $field->required ?? false ? 'required' : '' }}
            {!! $field->attributes ?? ''!!}>
        @foreach($field->options as $key => $value)
            <option value="{{ $key }}" {{ $field->value == $key ? 'selected' : '' }}>{{ $value }}</option>
        @endforeach
    </select>
@overwrite
