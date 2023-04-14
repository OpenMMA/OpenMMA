@extends('components.form.form-field')

@section('field-parent-classes')
@overwrite

@section('field')
    <input type="datetime-local"
           name="{{ $field->name }}"
           id="{{ $field->name }}"
           class="form-control{{ isset($field->class) ? ' ' . $field->class : '' }}"
           {{ isset($field->value) ? 'value="' . $field->value . '"' : \Carbon\Carbon::now()->format('Y-m-d\TH:i') }}
           {{ isset($field->placeholder) ? 'placeholder="' . $field->placeholder . '"' : '' }}
           {{ $field->required ?? false ? 'required' : '' }}
           {!! $field->attributes ?? ''!!}>
@overwrite
