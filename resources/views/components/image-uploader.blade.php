@include('header')
{{ Form::open(array('id' => 'image_upload_form', 'url' => '/', 'method' => 'post', 'enctype' => 'multipart/form-data')) }}
    {{ Form::file('images', array('multiple' => '', 'id' => 'images')) }}
{{ Form::close() }}
@push('scripts')
<script>
$("#images").change((input) => {
    if (input.target.files) {
        Array.from(input.target.files).forEach((file) => {
            var reader = new FileReader();
            // reader.ydAsDataURL(input.files[0]);
        });
        // var reader = new FileReader();
        // reader.onload = function (e) {
        //     $('#image_upload_preview').attr('src', e.target.result);
        // }
        // reader.readAsDataURL(input.files[0]);
    }
});
</script>
@endpush
@include('footer')