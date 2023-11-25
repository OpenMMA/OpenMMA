<div>
    <form wire:submit="save">
        <div class="d-flex gap-1">
            <input class="form-control" type="file" wire:model="user_file">
            <div class="flex-shrink-0">
                <button class="form-control btn btn-primary" type="submit">Import users</button>
            </div>
        </div>
        @error('user_file') <span class="text-danger">{{ $message }}</span> @enderror
        @if (session('status'))
            <span class="text-success">{{ session('status') }}</span>
        @endif
    </form>
</div>
