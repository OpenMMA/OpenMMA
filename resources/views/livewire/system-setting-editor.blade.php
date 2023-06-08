<div class="d-flex align-items-end gap-1 mb-3">
    <div class="flex-grow-1">
        <label class="form-label" for="{{ $key }}">{{ $label }}</label>
        @switch($setting->type)
            @case('text')
                <input wire:model.defer="value" type="text" name="{{ $key }}" class="form-control">
                @break
            @case('json')
                <textarea wire:model.defer="value" name="{{ $key }}" class="form-control font-monospace" cols="30" rows="10"></textarea>
                @break
            @case('num')
                <input wire:model.defer="value" type="number" name="{{ $key }}" class="form-control">
                @break
            @case('image')
                <img src="{{ $image ? $image->temporaryUrl() : '/img/'.$value.'?'.rand() /* Force refresh */ }}" class="img-thumbnail d-block mb-2" style="max-height: 200px; max-width: 200px;" alt="preview">
                @error('image')
                    <small class="text-danger">Image must be a png</small>
                @enderror
                <input wire:model="image" type="file" class="form-control">
                @break

        @endswitch
    </div>
    <div class="flex-shrink-0">
        @if ($setting->type == 'image')
            <button class="btn btn-secondary {{ $image ? 'd-none' : '' }}" disabled>Save</button>
            <button wire:click="save" class="btn btn-primary {{ $image ? '' : 'd-none' }}">Save</button>
        @else
            <button wire:target="value" wire:dirty.class="d-none" class="btn btn-secondary" disabled>Save</button>
            <button wire:target="value" wire:dirty.class.remove="d-none" wire:click="save" class="btn btn-primary d-none">Save</button>
        @endif
    </div>
</div>