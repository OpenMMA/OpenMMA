@extends('components.form.form-fields.textarea')

@pushOnce('scripts')
    <script src="{{ asset('js/tinymce/tinymce.min.js') }}" referrerpolicy="origin"></script>
@endPushOnce
@push('scripts')
    <script>
        tinymce.init({
            selector: 'textarea#{{ $field->name }}',
            plugins: 'code table lists',
            toolbar: 'undo redo | formatselect| bold italic | alignleft aligncenter alignright | indent outdent | bullist numlist | code | table',
            promotion: false
        });
    </script>
@endpush
