<div>
    <form wire:submit.prevent="updatePermissions">
        <div class="card">
            <div class="card-body">
            @foreach ($base_permission_defenition as $def)
                <h5>{{ $def['label'] }}</h5>
                @foreach ($def['elements'] as $permission)
                    <div class="form-check form-switch">
                        <label for="permission-{{ $permission }}">{{ \App\Models\Groups\Permission::$base_permissions[$permission] }}</label>
                        <input wire:model="permissions.{{ $permission }}" class="form-check-input" type="checkbox" role="switch" id="permission-{{ $permission }}">
                    </div>
                @endforeach
                <hr>                    
            @endforeach
            <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
        </div>        
    </form>
</div>
