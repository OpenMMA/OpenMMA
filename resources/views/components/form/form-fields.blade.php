@foreach ($fields as $field)
    @include('components.form.form-fields.' . $field->type, ['field' => $field])
@endforeach
