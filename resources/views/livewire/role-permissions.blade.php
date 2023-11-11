@php
    use Illuminate\Support\Facades\Auth;
    use \App\Models\Groups\Permission;
    $labels = array_merge(Permission::$group_permissions, Permission::$global_permissions);
    $group_name = explode('.', $this->role->name, 2)[0];
@endphp

<div>
    @if(Auth::user()->can($group_name.'.role.edit'))
    <div>
        <form wire:submit="updateGroupPermissions" class="pb-4">
            <div class="card d-inline-flex">
                <div class="card-header fs-5 text-bold">
                    Group-specific permissions
                </div>
                <div class="card-body">
                    <div class="d-inline-flex px-3">
                        @foreach ($group_permission_defenition as $def)
                        <div class="d-flex flex-column">
                            <h5>{{ $group->label }} {{ $def['label'] }}</h5>
                            <div class="d-flex flex-grow-1">
                                <div>
                                    @foreach ($def['elements'] as $permission)
                                    <div class="form-check form-switch">
                                        <label for="permission-{{ $permission }}">{{ $labels[$permission] }}</label>
                                        <input wire:model="group_permissions.{{ $permission }}" class="form-check-input" type="checkbox" role="switch" id="permission-{{ $permission }}">
                                    </div>
                                    @endforeach
                                </div>
                                @if (!$loop->last)
                                <div class="vr mx-4"></div>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <hr>
                <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </div>        
        </form>

        @if (Auth::user()->can('give_global_permissions'))
        <form wire:submit="updateGlobalPermissions" class="pb-4" id="global-permissions-form">
            <div class="card d-inline-flex">
                <div class="card-header fs-5 text-bold">
                    Global permissions
                    @if (!$global_permissions_enabled)
                        <button class="btn btn-success ms-3 px-2 py-1" id="enable-global-permissions" data-bs-toggle="modal" data-bs-target="#enable-global-form-modal">Enable</button>
                    @endif
                </div>
                <div class="card-body">
                    <div class="d-inline-flex px-3">
                        @foreach ($global_permission_defenition as $def)
                        <div class="d-flex flex-column">
                            <h5>{{ $def['label'] }} (global)</h5>
                            <div class="d-flex flex-grow-1">
                                <div>
                                    @foreach ($def['elements'] as $permission)
                                    <div class="form-check form-switch">
                                        <label for="permission-{{ $permission }}">{{ $labels[$permission] }}</label>
                                        <input wire:model="global_permissions.{{ $permission }}" class="form-check-input" type="checkbox" role="switch" id="permission-{{ $permission }}" @if(!$global_permissions_enabled) disabled @endif>
                                    </div>
                                    @endforeach
                                </div>
                                @if (!$loop->last)
                                <div class="vr mx-4"></div>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <hr>
                <button type="submit" class="btn btn-primary" @if(!$global_permissions_enabled) disabled @endif>Save changes</button>
                </div>
            </div>        
        </form>
        <div class="modal" tabindex="-1" id="enable-global-form-modal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5">Enable global permissions</h1>
                        <button class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>
                            Are you sure you want to enable global permissions for this role? 
                            This means that people with this role will potentially be able to view, edit, or delete content in other groups.
                        </p>
                        <p>
                            <b>
                                ONLY PEOPLE WITH MANAGEMENT ROLES ACROSS YOUR ENTIRE ASSOCIATION SHOULD BE ABLE TO DO THIS!!!
                            </b>
                        </p>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button wire:click="enableGlobalPermissions" class="btn btn-danger" id="enable-global-form-button" data-bs-dismiss="modal">I am sure, enable these settings</button>
                    </div>
                </div>
            </div>
        </div>
        @pushOnce('scripts')
        <script>
            $(document).ready(() => {
                $("#enable-global-permissions").click((e) => {
                    e.preventDefault(); 
                });
            });
        </script>
        @endPushOnce
        @endif
    </div>
    @else
    <h4>You do not have the rights to edit role permissions in this group.</h4>
    @endif
</div>