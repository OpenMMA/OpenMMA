@php
    use App\Models\Color;
    use Carbon\Carbon;

    $groups = \App\Models\Groups\Group::all();
    if (array_key_exists('group', $filters)) {
        $roles = \App\Models\Groups\Role::getGroupRoles($filters['group'])->mapWithKeys(fn($n) => [$n->id => $n]);  // TODO does this what I expect?
        $roles_for_select = array_combine(array_map(fn($r) => $r->name, $roles->all()), array_map(fn($r) => $r->title, $roles->all()));

    }
    
    $user_can_view = Auth::user()->can('user.view');
    $user_can_manage = Auth::user()->can('user.manage');
    $user_can_assign = Auth::user()->can('user.assign');
    $user_can_set_role = $group != null && Auth::user()->can($group->name.'.role.assign');
@endphp
<div>
    @if ($user_can_view || $group != null)  {{-- Make sure group members can view who is in their group --}}
    <input wire:model.live="query" class="form-control" type="text" placeholder="Search...">
    {{-- <div> --}}
        {{-- <input wire:model="query" class="form-control" type="text" placeholder="Search..."> --}}
        {{-- <button wire:click="search" class="btn btn-primary">Search</button> --}}
    {{-- </div> --}}
    <div class="table-responsive">
        <table class="table table-striped lw_table" id="user_table">
            <thead>
                <tr>
                    @foreach($cols as $col => $attrs)
                    <th scope="col">
                        <div class="d-flex text-nowrap">
                            {{ $col_opts[$col]['label'] }}
                            @if ($col_opts[$col]['sortable'])
                            <button wire:click="sortTable('{{ $col }}')" class="btn px-1 py-0">
                                @switch($attrs['sort_direction'])
                                @case('asc')
                                <i class="fa-solid fa-sort-up align-end"></i>
                                @break
                                @case('desc')
                                <i class="fa-solid fa-sort-down align-end"></i>
                                @break
                                    @default
                                    <i class="fa-solid fa-sort align-end"></i>
                                    @endswitch
                                </button>
                            @endif
                        </div>
                    </th>
                    @endforeach
                </tr>
            </thead>
            <tbody class="table-group-divider">
                @foreach ($users as $user)
                <tr>
                    @foreach ($cols as $col => $attrs)
                    <td>
                        @switch($col_opts[$col]['display'])
                            @case('check')
                                @if($user->$col)
                                <i class="fa-solid fa-check text-success"></i>
                                @else
                                <i class="fa-solid fa-xmark text-danger"></i>
                                @endif
                                @break
                            @case('date')
                                {{ Carbon::parse($user->$col)->format("d-m-Y") }}
                                @break
                            @case('groups')
                                @foreach ($user->$col as $group)
                                <span class="badge rounded-pill" style="background-color: {{ Color::find($groups->firstWhere('id', $group->group)->color)->primary }}">
                                    {{ $group->title }}
                                </span><br>
                                @endforeach
                                @break
                            @case('roles')
                                <div class="d-flex">
                                    <div id="roles" class="flex-grow-1">
                                        @foreach ($user->role_ids as $role_id)
                                            @if ($roles->has($role_id))
                                            <span class="badge rounded-pill" style="background-color: #ed036f">
                                                {{ $roles[$role_id]->title }}
                                            </span><br>
                                            @endif
                                        @endforeach
                                    </div>
                                    @if ($user_can_set_role)
                                        <div id="roles_select" class="d-none flex-grow-1">
                                            @include('components.form.form-fields.select-multiple', ['field' => (object)['name' => "roles",
                                                                                                                         'wrapper_classes' => '',
                                                                                                                         'options' => $roles_for_select, 
                                                                                                                         'value' => array_values(array_map(fn($rid) => $roles[$rid]->name, array_filter($user->role_ids->all(), fn($rid) => $roles->has($rid))))]])
                                        </div>
                                        <div class="flex-shrink-0">
                                            <a onclick="$(this).parent().siblings('#roles').toggleClass('d-none'); $(this).parent().siblings('#roles_select').toggleClass('d-none'); $(this).children().toggleClass('d-none');" class="btn btn-primary ms-1 px-1 py-0" href="#">
                                                <span>Edit roles</span>
                                                <span class="d-none" onclick="@this.call('updateRoles', {{$user->id}}, $(this).parent().parent().siblings('#roles_select').find('input[name=\'roles\']').val());">Update</span>
                                            </a>
                                        </div>
                                    @endif
                                </div>
                                @break;
                            @case('verify')
                                <div>
                                @if($user->user_verified_at)
                                    <i class="fa-solid fa-check text-success"></i>
                                @else
                                    @if ($user_can_manage)
                                        <button wire:click="verifyUser({{$user->id}})" class="btn btn-warning px-1 py-0">Verify</button>
                                    @else
                                        <i class="fa-solid fa-xmark text-danger"></i>
                                    @endif
                                @endif
                                </div>
                                @break
                            @case('val')
                            @default
                                {{ $user->$col }}
                        @endswitch
                    @endforeach
                    @if (($add_view_button || $add_add_button || $add_remove_button) && $user_can_view)
                    <td class="hide text-nowrap">
                        @if ($add_view_button)
                        <a href="{{ url("/dashboard/user/$user->id") }}"><i class="fa-solid fa-pencil pe-3"></i></a>
                        @endif
                        @if ($add_add_button && $user_can_assign)
                            <a href="#" wire:click="addUserToGroup({{$user->id}})"><i class="fa-solid fa-user-plus pe-3"></i></a>
                        @endif
                        @if ($add_remove_button && $user_can_assign)
                            <a href="#" wire:click="removeUserFromGroup({{$user->id}})"><i class="fa-solid fa-user-minus pe-3"></i></a>
                        @endif
                    </td>
                    @endif
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="d-flex align-items-center justify-content-between">
        <div class="small text-muted mb-3">
            Showing
            <span class="fw-semibold">{{ $users->firstItem() }}</span>
            to
            <span class="fw-semibold">{{ $users->lastItem() }}</span>
            {{-- TODO sometimes 'of' dissapears??? --}}
            of
            <span class="fw-semibold">{{ $users->total() }}</span>
            results
        </div>
        <div>
            @if (!$disable_entries_per_page)
            <div class="d-inline-block small text-muted text-nowrap pe-1">
                Items per page:
            </div>
            <div class="d-inline-block me-2 mb-3">
                <select wire:model.live="entries_per_page" class="form-select form-select-sm">
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="100">100</option>
                </select>
            </div>
            @endif
            <div class="d-inline-block">
                {{ $users->links() }}
            </div>
        </div>
    </div>
    @endif
</div>
