<div class="d-flex align-items-end gap-1 mb-3">
    <div class="flex-grow-1">
        <label class="form-label" for="{{ $key }}">{{ $label }}</label>
        @switch($setting->type)
            @case('text')
                <input wire:model="value" type="text" name="{{ $key }}" class="form-control">
                @break
            @case('json')
                <textarea wire:model="value" name="{{ $key }}" class="form-control font-monospace" cols="30" rows="10"></textarea>
                @break
            @case('num')
                <input wire:model="value" type="number" name="{{ $key }}" class="form-control">
                @break
            @case('image')
                <img src="{{ $image ? $image->temporaryUrl() : '/img/'.$value.'?'.rand() /* Force refresh */ }}" class="img-thumbnail d-block mb-2" style="max-height: 200px; max-width: 200px;" alt="preview">
                @error('image')
                    <small class="text-danger">Image must be a png</small>
                @enderror
                <input wire:model.live="image" type="file" class="form-control">
                @break
            @case('form')
                @include('components.form-wysiwyg', ['value' => null, 'wire' => 'value'])
                @break

        @endswitch
    </div>
    <div class="flex-shrink-0">
        @if ($setting->type == 'image')
            <button class="btn btn-secondary {{ $image ? 'd-none' : '' }}" disabled>Save</button>
            <button wire:click="save" class="btn btn-primary {{ $image ? '' : 'd-none' }}">Save</button>
        @elseif ($setting->type == 'form')
        @else
            <button wire:target="value" wire:dirty.class="d-none" class="btn btn-secondary" disabled>Save</button>
            <button wire:target="value" wire:dirty.class.remove="d-none" wire:click="save" class="btn btn-primary d-none">Save</button>
        @endif
    </div>
</div>
