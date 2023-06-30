@extends('components.form.form-field')

@section('field-parent-classes')
@overwrite

@section('field')
    <input type="file"
           name="{{ $field->name }}"
           id="{{ $field->name }}"
           class="form-control{{ isset($field->class) ? ' ' . $field->class : '' }}"
           {{ $field->multiple ?? false ? 'multiple' : '' }}
           @if (isset($field->wire)) wire:model.defer="{{ $field->wire }}" @endif
           {{ $field->required ?? false ? 'required' : '' }}
           {!! $field->attributes ?? '' !!}>
@overwrite
