@extends('components.form.form-field')

@pushOnce('scripts')
<script>
    function selectorInputUpdateList(t, wire) {
        let val = JSON.stringify($.map($(t).children('span'), (e) => $(e).attr('value')));
        $(t).children('input').val(val);
        if (wire)
            wire.$set($(t).children('input').attr('wire:model'), val);
    }
    function selectorInputAdd(t, wire) {
        let v = $(t).val();
        let l = $(t).children(`[value='${v}']`).text();
        if (v == '')
            return;
        $(t).children(`[value='${v}']`).prop('disabled', true);
        $(t).val('');
        $(t).siblings('#selected_items').append(`<span value="${v}" class="my-1 me-1 badge rounded-pill text-bg-primary">${l} <button class="m-0 p-0 ms-1 border-0 bg-transparent text-reset" role="button" onclick="selectorInputRemove(this, @if ($field?->wire ?? false) window.Livewire.find('${wire.$id}') @else false @endif)"><span class="fa-solid fa-xmark"></span></button></span>`);
        selectorInputUpdateList($(t).siblings('#selected_items'), wire);
    }
    function selectorInputRemove(t, wire) {
        let v = $(t).parent().attr('value');
        let p = $(t).parent().parent();
        p.siblings('select').children(`[value='${v}']`).prop('disabled', false);
        $(t).parent().remove();
        selectorInputUpdateList(p, wire);
    }
</script>
@endPushOnce


@section('field-parent-classes')
@overwrite

@php
    if (isset($field->wire)) {
        // NOTE does not support multi-dimensional arrays
        $index = explode('.', $field->wire);
        $vals = json_decode((sizeof($index) > 1) ? ${$index[0]}[$index[1]] : ${$index[0]});
    } else {
        $vals = isset($field->value) ? (is_string($field->value) ? json_decode($field->value) : $field->value) : [];
    }
@endphp
@section('field')
    <div wire:ignore class="p-2 border rounded">
        <div id="selected_items">
            <input name="{{ $field->name }}" type="hidden" @if (isset($field->wire)) wire:model="{{ $field->wire }}" @endif value="{{ isset($field->value) ? (is_string($field->value) ?  $field->value : json_encode($field->value)) : '[]' }}">
            @foreach($field->options as $key => $value)
                @if (in_array($key, $vals))            
                <span value="{{ $key }}" class="my-1 me-1 badge rounded-pill text-bg-primary" {{ is_array($value) ? "style='background-color:".$value['color'].";'" : '' }}>{{ is_array($value) ? $value['label'] : $value }} <button class="m-0 p-0 ms-1 border-0 bg-transparent text-reset" role="button" onclick="selectorInputRemove(this, @if ($field?->wire ?? false) @this @else false @endif)"><span class="fa-solid fa-xmark"></span></button></span>
                @endif
            @endforeach
        </div>
        <select class="form-select form-select-sm mt-2" onchange="selectorInputAdd(this, @if (isset($field->wire)) @this @else false @endif);">
            <option value="" selected>Add option...</option>
            @foreach($field->options as $key => $value)
                <option value="{{ $key }}" {{ is_array($value) ? "color='".$value['color']."'" : '' }} {{ in_array($key, $vals) ? 'disabled' : '' }}>{{ is_array($value) ? $value['label'] : $value }}</option>
            @endforeach
        </select>
    </div>
@overwrite
