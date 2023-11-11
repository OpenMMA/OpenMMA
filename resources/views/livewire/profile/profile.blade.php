<div>
    <form wire:submit.prevent="update">
        @csrf
        @include('components.form.form-fields.text', ['field' => (object)array('name' => 'first_name', 'required' => true, 'label' => 'First name', 'attributes' => 'wire:model="first_name"')])
        @include('components.form.form-fields.text', ['field' => (object)array('name' => 'last_name', 'required' => true, 'label' => 'Last name', 'attributes' => 'wire:model="last_name"')])
        @include('components.form.form-fields.email', ['field' => (object)array('name' => 'email', 'required' => true, 'label' => 'Email address', 'attributes' => 'wire:model="email"')])
        <hr class="m-4">
        @include('components.form.form-fields', ['fields' => $custom_fields])
        <button type="submit" class="btn btn-primary">Save</button>
    </form>

    <script>
        $(document).ready(function() {
            Livewire.hook('message.processed', (el, component) => {
                console.log($('#first_name').val());
                $('#navbar-first-name').text($('#first_name').val());
            });
        });
    </script>
</div>
