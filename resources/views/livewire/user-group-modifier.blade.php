<div class="d-inline">
    @if (Auth::user()->can('user.assign'))
        @if ($render_add)
        <a href="#" wire:click="add"><i class="fa-solid fa-user-plus pe-3"></i></a>
        @endif
        @if ($render_remove)
        <a href="#" wire:click="remove"><i class="fa-solid fa-user-minus pe-3"></i></a>
        @endif
    @endif
</div>
