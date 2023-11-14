<div>
    <script id="{{$selector_id}}">
        document.addEventListener('livewire:initialized', () => {
            @this.on('deleted', (event) => {
                $("#{{$selector_id}}").closest('tr').remove();
            });
        });
    </script>
    <button wire:click="delete" wire:confirm="Are you sure you want to delete '{{$model->label}}'?" role="button" class="btn btn-danger px-1 py-0">Delete</button>
</div>
