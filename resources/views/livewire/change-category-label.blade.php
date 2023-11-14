<div>
    <div class="d-flex align-items-center">
        <div>
            <input wire:model="label" type="text" class="form-control">
        </div>
        <div class="mx-2">
            <button wire:dirty wire:click="save" onclick="$(this).closest('#label').children('#text').html($(this).parent().siblings(0).children('input').val()); $(this).closest('#label').siblings('#editbutton').children('a').click();" class="btn btn-primary px-1 py-0">Save</button>
        </div>
    </div>
    
</div>
