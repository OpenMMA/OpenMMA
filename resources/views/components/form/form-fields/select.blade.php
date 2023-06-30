@extends('components.form.form-field')

@pushOnce('scripts')
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>
@endPushOnce

@pushOnce('styles')
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.bootstrap5.min.css" rel="stylesheet">
    <script>
        new TomSelect('#{{ $field->name }}', {
            create: {{ $field->create ?? false ? 'true' : 'false' }}
        });
    </script>
@endPushOnce


@section('field-parent-classes')
@overwrite

@section('field')
    <div wire:ignore>
        <select id="{{ $field->name }}" name="{{ $field->name . ($field->multiple ?? false ? '[]' : '')}}"
                id="{{ $field->name }}"
                class="form-select form-control{{ isset($field->class) ? ' ' . $field->class : '' }}"
                {{ $field->multiple ?? false ? 'multiple' : '' }}
                @if (isset($field->wire)) wire:model.defer="{{ $field->wire }}" @endif
                {{ $field->required ?? false ? 'required' : '' }}
                {!! $field->attributes ?? ''!!}>
            <option value="">{{ $field->placeholder ?? 'Please select one' . ($field->multiple ?? false ? ' or more...' : '...') }}</option>
            @foreach($field->options as $key => $value)
                <option value="{{ $key }}" {{ $field->value ?? '' == $key ? 'selected' : '' }}>{{ $value }}</option>
            @endforeach
        </select>
    </div>
@overwrite
