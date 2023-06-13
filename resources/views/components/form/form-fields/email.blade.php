@extends('components.form.form-field')

@section('field-parent-classes')
@overwrite

@section('field')
    <input type="email"
           name="{{ $field->name }}"
           id="{{ $field->name }}"
           class="form-control{{ isset($field->class) ? ' ' . $field->class : '' }}"
           @if (isset($field->value)) value="{{ $field->value }}" @endif
           @if (isset($field->placeholder)) placeholder="{{ $field->placeholder }}" @endif
           {{ $field->required ?? false ? 'required' : '' }}
           {!! $field->attributes ?? '' !!}>
@overwrite
