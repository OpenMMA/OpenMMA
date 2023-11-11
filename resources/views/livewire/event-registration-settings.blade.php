<div>
    <h4>Event Registration</h4>
    <div class="form-check form-switch">
        <label for="registerable">People can register</label>
        <input wire:model.live="registerable" class="form-check-input" type="checkbox" role="switch" id="registerable">
    </div>
    <div>
        @if ($event->registerable)
        <hr>
        <form wire:submit.prevent="setMaxRegistrations">
            <div class="d-flex gap-1 m-2">
                <div class="flex-grow-1">
                    <label class="form-label" for="max_registrations">Max. registrations (0 for no limit)</label>
                    <input wire:model="max_registrations" class="form-control" id="max_registrations" type="number" min="0">
                </div>
                <div class="align-self-end">
                    <input type="submit" class="btn btn-primary" value="Change">
                </div>
            </div>
        </form>
        @if ($max_registrations > 0)
        <div class="form-check form-switch">
            <label for="queueable">Enable queueing when full</label>
            <input wire:model.live="queueable" class="form-check-input" type="checkbox" role="switch" id="queueable">
        </div>
        @endif
        <hr>
        <div class="form-check form-switch">
            <label for="require_additional_data">Require additional data</label>
            <input wire:model.live="require_additional_data" class="form-check-input" type="checkbox" role="switch" id="require_additional_data">
        </div>
        @if ($event->require_additional_data)
        <form wire:submit.prevent="setAdditionalDataFields">
            <div class="d-flex gap-1 m-2">
                <div class="flex-grow-1">
                    <label class="form-label" for="additional_data_fields">Additional data fields</label>
                    <textarea wire:model="additional_data_fields" class="form-control" id="additional_data_fields" rows="5"></textarea>
                </div>
                <div class="align-self-end">
                    <input type="submit" class="btn btn-primary" value="Change">
                </div>
            </div>
        </form>
        @endif
        <hr>
        <div class="form-check form-switch">
            <label for="allow_externals">Allow externals to register for this activity</label>
            <input wire:model.live="allow_externals" class="form-check-input" type="checkbox" role="switch" id="allow_externals">
        </div>
        <div class="form-check form-switch">
            <label for="only_allow_groups">Only allow specified groups to register</label>
            <input wire:model.live="only_allow_groups" class="form-check-input" type="checkbox" role="switch" id="only_allow_groups">
        </div>
        @if ($only_allow_groups)
            TODO add selection here
        @endif
        @endif
    </div>
</div>
