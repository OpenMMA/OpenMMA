<div>
    @if (Auth::user()->can(App\Models\Groups\Group::find($event->group)->name.'.registration.view'))
    @if ($event->registerable)
        <table class="table table-striped lw_table" id="user_table">
            <thead>
                <tr>
                    @foreach($registration_header_int as $col => $attrs)
                    <th scope="col">
                        {{ $attrs['label'] }}
                    </th>
                    @endforeach
                </tr>
            </thead>
            <tbody class="table-group-divider">
                @foreach ($registrations_int as $registration)
                    <tr>
                        @foreach ($registration_header_int as $col => $attrs)
                        <td>
                            @switch($col)
                                @case('name')
                                    {{ $registration['first_name'] }} {{ $registration['last_name'] }}
                                    @break
                                @case('email')
                                @case('created')
                                    {{ $registration[$col] }}
                                    @break
                                @default
                                    {{ $registration['data'][$col] }}
                            @endswitch
                        </td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
    @if ($event->allow_externals)
        <table class="table table-striped lw_table" id="user_table">
            <thead>
                <tr>
                    @foreach($registration_header_ext as $col => $attrs)
                    <th scope="col">
                        {{ $attrs['label'] }}
                    </th>
                    @endforeach
                </tr>
            </thead>
            <tbody class="table-group-divider">
                @foreach ($registrations_ext as $registration)
                    <tr>
                        @foreach ($registration_header_ext as $col => $attrs)
                        <td>
                            @switch($col)
                                @case('name')
                                @case('email')
                                @case('created')
                                    {{ $registration[$col] }}
                                    @break
                                @case('verified')
                                    @if($registration[$col])
                                    <i class="fa-solid fa-check text-success"></i>
                                    @else
                                    <i class="fa-solid fa-xmark text-danger"></i>
                                    @endif
                                    @break
                                @default
                                    {{ $registration['data'][$col] }}
                            @endswitch
                        </td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
    @else
        <h5>Registration is not possible for this event.</h5>
    @endif
    @endif
</div>
