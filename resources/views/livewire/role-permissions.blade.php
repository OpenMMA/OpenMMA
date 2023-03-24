<div>
    <form wire:submit.prevent="updatePermissions">
        @foreach ($permissions as $permission => $has)
        {{-- {{dd($permission, $has)}} --}}
        {{-- {{ dd($permissions) }} --}}
        <div class="form-check form-switch">
            {{-- {{dd($permission_labels)}} --}}
            <label for="permission-{{ $permission }}">{{ $permission_labels[$permission] }}</label>
            <input wire:model="permissions.{{ $permission }}" class="form-check-input" type="checkbox" role="switch" id="permission-{{ $permission }}">
        </div>
        @endforeach
        <button type="submit" class="btn btn-primary">Save changes</button>
    </form>
</div>
