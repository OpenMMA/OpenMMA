@extends('components.form.form-field')

@section('field-parent-classes')
@overwrite

@section('field')
    <input type="text"
           name="{{ $field->name }}"
           id="{{ $field->name }}"
           class="form-control{{ isset($field->class) ? ' ' . $field->class : '' }}"
           @if (isset($field->value)) value="{{ $field->value }}" @endif
           @if (isset($field->placeholder)) placeholder="{{ $field->placeholder }}" @endif
           @if (isset($field->wire)) wire:model.defer="{{ $field->wire }}" @endif
           {{ $field->required ?? false ? 'required' : '' }}
           {!! $field->attributes ?? '' !!}>
@overwrite
