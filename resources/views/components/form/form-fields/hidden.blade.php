@extends('components.form.form-field')

@section('field-parent-classes')
@overwrite

@section('field')
    <input type="hidden"
           name="{{ $field->name }}"
           id="{{ $field->name }}"
           {{ isset($field->class) ? 'class="' . $field->class . '"' : '' }}
           {{ isset($field->value) ? 'value="' . $field_value . '"' : '' }}
           {{ $field->required ?? false ? 'required' : '' }}
           {{ $field->attributes ?? ''}}>
@overwrite
