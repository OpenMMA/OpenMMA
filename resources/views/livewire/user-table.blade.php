@php
    use Carbon\Carbon;

    $groups = \App\Models\Groups\Group::all();
    if (array_key_exists('group', $filters)) {
        $roles = \App\Models\Groups\Role::getGroupRoles($filters['group'])->mapWithKeys(fn($n) => [$n->id => $n]);
    }

    // dd($roles);
@endphp
<div>
    <input wire:model="query" class="form-control" type="text" placeholder="Search...">
    <table class="table table-striped" id="user_table">
        <thead>
            {{-- TODO fix table column width to be minimal but not less than header width --}}
            <tr>
                @foreach($cols as $col => $attrs)
                <th scope="col">
                    <div>
                        {{ $col_opts[$col]['label'] }}
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
                                <span class="badge rounded-pill" style="background-color: {{ $groups->firstWhere('id', $group->group)->hexColor }}">
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
                <td class="hide"><a href="{{ url("/dashboard/user/$user->id") }}" class="btn btn-primary px-1 py-0">View</a></td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="flex-sm-fill d-sm-flex align-items-sm-center justify-content-sm-between">
        <div>
            <p class="small text-muted">
                Showing    
                <span class="fw-semibold">{{ $users->firstItem() }}</span>
                to
                <span class="fw-semibold">{{ $users->lastItem() }}</span>
                {{-- TODO sometimes 'of' dissapears??? --}}
                of
                <span class="fw-semibold">{{ $users->total() }}</span>
                results
            </p>
        </div>
        <div class="d-sm-flex">
            <div class="d-sm-flex flex-row align-items-start pe-3">
                <p class="small text-muted text-nowrap pe-2">    
                    Items per page:
                </p>
                <select wire:model="entries_per_page" class="form-select form-select-sm">
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="100">100</option>
                </select>
            </div>
            <div>
                {{ $users->links() }}
            </div>  
        </div>
    </div>
</div>
