@extends('components.form.form-field')

@section('field-parent-classes')
    form-check
@overwrite

@section('field')
    <input type="checkbox"
           name="{{ $field->name }}"
           id="{{ $field->name }}"
           class="form-check-input{{ isset($field->class) ? ' ' . $field->class : '' }}"
           {{ $field->value ?? false ? 'checked' : '' }}
           @if (isset($field->wire)) wire:model.defer="{{ $field->wire }}" @endif
           {{ $field->required ?? false ? 'required' : '' }}
           {!! $field->attributes ?? '' !!}>
@overwrite
