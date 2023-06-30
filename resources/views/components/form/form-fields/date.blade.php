@extends('components.form.form-field')

@section('field-parent-classes')
@overwrite

@section('field')
    <input type="datetime-local"
           name="{{ $field->name }}"
           id="{{ $field->name }}"
           class="form-control{{ isset($field->class) ? ' ' . $field->class : '' }}"
           value="{{ $field->value ?? \Carbon\Carbon::now()->format('Y-m-d\TH:i') }}"
           @if (isset($field->placeholder)) placeholder="{{ $field->placeholder }}" @endif
           @if (isset($field->wire)) wire:model.defer="{{ $field->wire }}" @endif
           {{ $field->required ?? false ? 'required' : '' }}
           {!! $field->attributes ?? '' !!}>
@overwrite
