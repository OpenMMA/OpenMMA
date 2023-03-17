<div>
    <h4>Event Registration</h4>
    <div class="form-check form-switch">
        <label for="registerable">Members can register</label>
        <input wire:model="registerable" class="form-check-input" type="checkbox" role="switch" id="registerable">
    </div>
    <div>
        @if ($event->registerable)
        <div class="form-check form-switch">
            <label for="enable_comments">Enable comments</label>
            <input wire:model="enable_comments" class="form-check-input" type="checkbox" role="switch" id="enable_comments">
        </div>
        <form wire:submit.prevent="setMaxRegistrations">
            <div class="d-flex gap-1 mt-2">
                <div class="flex-grow-1">
                    <label class="form-label" for="max_registrations">Max. registrations (0 for no limit)</label>
                    <input wire:model="max_registrations" class="form-control" id="max_registrations" type="number" min="0">
                </div>
                <div class="align-self-end">
                    <input type="submit" class="btn btn-primary" value="Change">
                </div>
            </div>
        </form>
        @endif
    </div>
</div>
