@php
    use Carbon\Carbon;

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
                        {{ $attrs['label'] }}
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
                <td>{{ $user->first_name }}</td>
                <td>{{ $user->last_name }}</td>
                <td>{{ $user->email }}</td>
                <td class="text-center">
                @if($user->email_verified_at)
                    <i class="fa-solid fa-check text-success"></i>
                    @else
                    <i class="fa-solid fa-xmark text-danger"></i>
                    @endif
                </td>
                <td>{{ Carbon::parse($user->created_at)->format("d-m-Y") }}</td>
                <td class="text-center">
                @livewire('verify-user', ['user' => $user], key($user->id))
                </td>
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
