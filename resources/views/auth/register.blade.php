@include('header')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-5 mx-2 p-0 position-relative">

            <div class="card shadow-sm m-4">
                <div class="card-header text-center fs-4">
                    Register
                </div>
                <div class="card-body">
                    @include('components.form', ['form_name' => 'register_form',
                                                 'form_submit' => 'Register',
                                                 'form_target' => '/register',
                                                 'form_fields' => array_merge([
                                                    (object)array('type' => 'text', 'name' => 'first_name', 'required' => true, 'label' => 'First name', 'error' => 'first_name'),
                                                    (object)array('type' => 'text', 'name' => 'last_name', 'required' => true, 'label' => 'Last name', 'error' => 'last_name'),
                                                    (object)array('type' => 'email', 'name' => 'email', 'required' => true, 'label' => 'Email address', 'error' => 'email'),
                                                    (object)array('type' => 'password', 'name' => 'password', 'required' => true, 'label' => 'Password', 'error' => 'password'),
                                                    (object)array('type' => 'password', 'name' => 'password_confirmation', 'required' => true, 'label' => 'Password (confirm)', 'error' => 'password_confirm'),
                                                    (object)array('type' => 'divider', 'class' => 'm-4'),
                                                ], array_map(fn($v) => (object)$v, setting('account.custom_fields'))
                                                )])
                </div>
            </div>
        </div>
    </div>
</div>
@include('footer')