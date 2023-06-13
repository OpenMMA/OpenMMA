@extends('components.form.form-field')

@section('field-parent-classes')
@overwrite

@section('field')
    <input type="hidden"
           name="{{ $field->name }}"
           id="{{ $field->name }}"
           @if (isset($field->class)) class="{{ $field->class }}" @endif
           @if (isset($field->value)) value="{{ $field->value }}" @endif
           {{ $field->required ?? false ? 'required' : '' }}
           {!! $field->attributes ?? '' !!}>
@overwrite
