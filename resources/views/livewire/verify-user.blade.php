<div>
    @if($user->user_verified_at)
    <i class="fa-solid fa-check text-success"></i>
    @else
    <button wire:click="verify" class="btn btn-warning px-1 py-0">Verify</button>
    {{-- @include('components.form', ['form_name' => 'verify_user_form_' . $user->id,
                                    'form_submit' => 'Verify',
                                    'form_target' => "/user/$user->id/verify",
                                    'form_submit_classes' => '',
                                    'form_fields' => []]) --}}
    
    @endif
</div>
