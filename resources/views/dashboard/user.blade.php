@extends('dashboard.layout')

@section('dashboard.content')
<h5 class="mb-0 text-muted">User</h5>
<h2>{{ $user->name }}</h2>
<hr class="border-secondary">
<p>{{ $user->email }} - Email {{ $user->email_verified_at ? '' : 'not' }} verified.</p>
<p>Registered at {{ $user->created_at }}</p>
<h4>Other data</h4>
    @foreach(setting('account.custom_fields') as $data_field)
        @if ($data_field->type == 'select')
            <p>{{ $data_field->label }}:
            @if ($data_field->multiple)
                @foreach($user->custom_data[$data_field->name] as $di)
                    {{ $data_field->options->$di ?? $di }}
                    @if (!$loop->last)
                        ,
                    @endif
                @endforeach
            @else
                {{ $data_field->options->$di }}
            @endif

            </p>
        @else
            <p>{{ $data_field->label }}: {{ $user->custom_data[$data_field->name] }}</p>
        @endif
    @endforeach
<h4>Groups</h4>
@endsection
