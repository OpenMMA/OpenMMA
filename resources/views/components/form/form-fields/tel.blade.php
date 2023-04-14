@extends('components.form.form-field')

@section('field-parent-classes')
@overwrite

@section('field')
    <input type="tel"
           name="{{ $field->name }}"
           id="{{ $field->name }}"
           class="form-control{{ isset($field->class) ? ' ' . $field->class : '' }}"
           {{ isset($field->value) ? 'value="' . $field->value . '"' : '' }}
           {{ isset($field->placeholder) ? 'placeholder="' . $field->placeholder . '"' : '' }}
           {{ isset($field->pattern) ? 'pattern="' . $field->pattern . '"' : '' }}
           {{ $field->required ?? false ? 'required' : '' }}
           {!! $field->attributes ?? ''!!}>
@overwrite
