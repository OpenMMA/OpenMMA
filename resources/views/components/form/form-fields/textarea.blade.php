@extends('components.form.form-field')

@section('field-parent-classes')
@overwrite

@section('field')
    <textarea
        name="{{ $field->name }}"
        id="{{ $field->name }}"
        class="form-control{{ isset($field->class) ? ' ' . $field->class : '' }}"
        rows="{{ $field->rows ?? 10 }}"
        {{ isset($field_value) ? 'value="' . $field_value . '"' : '' }}
        {{ isset($field->placeholder) ? 'placeholder="' . $field->placeholder . '"' : '' }}
        {{ $field->required ?? false ? 'required' : '' }}
        {{ $field->attributes ?? ''}}>
    </textarea>
@overwrite
