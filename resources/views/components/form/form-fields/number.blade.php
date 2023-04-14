@extends('components.form.form-field')

@section('field-parent-classes')
@overwrite

@section('field')
    <input type="number"
           name="{{ $field->name }}"
           id="{{ $field->name }}"
           class="form-control{{ isset($field->class) ? ' ' . $field->class : '' }}"
           {{ isset($field->value) ? 'value="' . $field->value . '"' : '' }}
           {{ isset($field->placeholder) ? 'placeholder="' . $field->placeholder . '"' : '' }}
           {{ isset($field->min) ? 'min="' . $field->min . '"' : '' }}
           {{ isset($field->max) ? 'max="' . $field->max . '"' : '' }}
           {{ isset($field->step) ? 'step="' . $field->step . '"' : '' }}
           {{ $field->required ?? false ? 'required' : '' }}
           {{ $field->attributes ?? ''}}>
@overwrite
