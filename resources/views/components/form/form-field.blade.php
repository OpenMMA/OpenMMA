<div class="{{ $field->wrapper_classes ?? 'mb-3' }} @yield('field-parent-classes')">
    @if(isset($field->label) && !($field->label_after ?? false))
        <label class="form-label" for="{{ $field->name }}">{{ $field->label }}</label>
    @endif

    @yield('field')

    @if($errors->has($field->name))
        <div class="form-text text-danger">{{ $errors->first($field->name) }}</div>
    @endif

    @if(isset($field->label) && ($field->label_after ?? false))
        <label class="form-label" for="{{ $field->name }}">{{ $field->label }}</label>
    @endisset
</div>
