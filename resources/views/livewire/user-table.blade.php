@php
    use App\Models\Color;
    use Carbon\Carbon;

    $groups = \App\Models\Groups\Group::all();
    if (array_key_exists('group', $filters)) {
        $roles = \App\Models\Groups\Role::getGroupRoles($filters['group'])->mapWithKeys(fn($n) => [$n->id => $n]);
    }

@endphp
<div>
    <input wire:model="query" class="form-control" type="text" placeholder="Search...">
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
                                @foreach ($user->role_ids as $role_id)
                                    @if ($roles->has($role_id))
                                    <span class="badge rounded-pill" style="background-color: #ed036f">
                                        {{ $roles[$role_id]->title }}
                                    </span><br>
                                    @endif
                                @endforeach
                                @break;
                            @case('verify')
                                @livewire('verify-user', ['user' => $user], key($user->id))
                                @break
                            @case('val')
                            @default
                                {{ $user->$col }}
                        @endswitch
                    @endforeach
                    @if ($add_view_button || $add_add_button || $add_remove_button)
                    <td class="hide text-nowrap">
                        @if ($add_view_button)
                        <a href="{{ url("/dashboard/user/$user->id") }}"><i class="fa-solid fa-pencil pe-3"></i></a>
                        @endif
                        @if ($add_add_button)
                        @livewire('user-group-modifier', ['user' => $user, 'group' => $group, 'render_add' => true], key($user->id))
                        @endif
                        @if ($add_remove_button)
                        @livewire('user-group-modifier', ['user' => $user, 'group' => $group, 'render_remove' => true], key($user->id))
                        @endif
                    </td>
                    @endif
                    <td class="hide"><a href="{{ url("/dashboard/user/$user->id") }}" class="btn btn-primary px-1 py-0">View</a></td>
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
                <select wire:model="entries_per_page" class="form-select form-select-sm">
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
</div>
