@extends('components.form.form-field')

@section('field-parent-classes')
@overwrite

@section('field')
    <div wire:ignore>
        <select id="{{ $field->name }}" name="{{ $field->name . ($field->multiple ?? false ? '[]' : '')}}"
                id="{{ $field->name }}"
                class="form-select form-control{{ isset($field->class) ? ' ' . $field->class : '' }}"
                {{ $field->multiple ?? false ? 'multiple' : '' }}
                @if (isset($field->wire)) wire:model="{{ $field->wire }}" @endif
                {{ $field->required ?? false ? 'required' : '' }}
                {!! $field->attributes ?? ''!!}>
            <option value="">{{ $field->placeholder ?? 'Please select one' . ($field->multiple ?? false ? ' or more...' : '...') }}</option>
            @foreach($field->options as $key => $value)
                <option value="{{ $key }}" {{ $field->value ?? '' == $key ? 'selected' : '' }}>{{ $value }}</option>
            @endforeach
        </select>
    </div>
@overwrite
