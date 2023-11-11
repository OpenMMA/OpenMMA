@extends('components.form.form-field')

@section('field-parent-classes')
@overwrite

@section('field')
    <input type="number"
           name="{{ $field->name }}"
           id="{{ $field->name }}"
           class="form-control{{ isset($field->class) ? ' ' . $field->class : '' }}"
           @if (isset($field->value)) value="{{ $field->value }}" @endif
           @if (isset($field->placeholder)) placeholder="{{ $field->placeholder }}" @endif
           @if (isset($field->wire)) wire:model="{{ $field->wire }}" @endif
           @if (isset($field->min)) min="{{ $field->min }}" @endif
           @if (isset($field->max)) max="{{ $field->max }}" @endif
           @if (isset($field->step)) step="{{ $field->step }}" @endif
           {{ $field->required ?? false ? 'required' : '' }}
           {!! $field->attributes ?? '' !!}>
@overwrite
