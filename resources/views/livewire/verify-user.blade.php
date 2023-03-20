<div>
    @if($user->user_verified_at)
    <i class="fa-solid fa-check text-success"></i>
    @else
    <button wire:click="verify" class="btn btn-warning px-1 py-0">Verify</button>
    @endif
</div>
