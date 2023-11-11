<div>
    <h4>Publishing</h4>
    <div class="d-inline-flex pb-2">
        <label class="pe-2" for="publish-status-select align-middle">Status:</label>
        <select wire:model.live="status" wire:loading.attr="disabled" class="form-select form-select-sm" id="publish-status-select">
            @foreach (['draft' => 'Draft', 'published' => 'Published', 'unlisted' => 'Unlisted'] as $status_val => $status_label)
            <option value="{{ $status_val }}" {{ $status_val == $status ? 'selected' : '' }}>{{ $status_label }}</option>
            @endforeach
        </select>
    </div>
    <div class="d-inline-flex pb-2">
        <label class="pe-2" for="publish-status-select align-middle">Visibility:</label>
        <select wire:model.live="visibility" wire:loading.attr="disabled" class="form-select form-select-sm" id="publish-status-select">
            @foreach (['visible' => 'Visible to everyone', 'protected' => 'Only visible when logged in', 'local' => 'Only visible to members of this group', 'hidden' => 'Only visible to you', 'selection' => 'Only visible to the selected groups'] as $visibility_val => $visibility_label)
            <option value="{{ $visibility_val }}" {{ $visibility_val == $visibility ? 'selected' : '' }}>{{ $visibility_label }}</option>
            @endforeach
        </select>
    </div>
    @if ($visibility == 'selection')
        TODO add selection here
    @endif
</div>
