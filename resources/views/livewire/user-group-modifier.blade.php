<div>
    @if ($render_add)
    <button wire:click="add" class="btn"><i class="fa-solid fa-plus"></i></button>
    @endif
    @if ($render_remove)
    <button wire:click="remove" class="btn"><i class="fa-solid fa-trash"></i></button>
    @endif
</div>
