@include('header')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-5 mx-2 p-0 position-relative">

            <div class="card shadow-sm m-4">
                <div class="card-header text-center fs-4">
                    Reset password
                </div>
                <div class="card-body">
                    @include('components.form', ['form_name' => 'password_reset_form',
                                                'form_submit' => 'Reset password',
                                                'form_target' => '/reset-password',
                                                'form_fields' => [
                                                    (object)array('type' => 'email', 'name' => 'email', 'default' => Request::get('email'), 'required' => true, 'label' => 'Email address', 'error' => 'email'),
                                                    (object)array('type' => 'password', 'name' => 'password', 'required' => true, 'label' => 'Password', 'error' => 'password'),
                                                    (object)array('type' => 'password', 'name' => 'password_confirmation', 'required' => true, 'label' => 'Password (confirm)', 'error' => 'password_confirm'),
                                                    (object)array('type' => 'hidden', 'name' => 'token', 'value' => request()->route('token'))
                                                ]])
                </div>
            </div>
        </div>
    </div>
</div>
@include('footer')