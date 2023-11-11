<div>
    <form wire:submit="save">
        <input class="form-control" type="file" wire:model="user_file">
        @error('user_file') <span class="error">{{ $message }}</span> @enderror
        <button class="form-control" type="submit">Import users</button>
    </form>
</div>
