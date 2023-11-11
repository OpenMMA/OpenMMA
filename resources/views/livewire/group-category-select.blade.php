<div class="d-flex align-items-center">
    <div>
        <select wire:model="category" wire:loading.attr="disabled" class="form-select">
            <option value="-1">uncategorized</option>
            @foreach($categories as $category)
            <option value="{{ $category->id }}">{{ $category->label }}</option>
            @endforeach
        </select>
    </div>
    <div class="mx-2">
        <button wire:dirty wire:click="saveCategory" class="btn btn-primary px-1 py-0">Save</button>
    </div>
</div>
