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
            <p><b>{{ $data_field->label }}:</b>
            @if ($data_field->multiple)
                @foreach($user->custom_data[$data_field->name] as $di)
                    {{ $data_field->options->$di ?? $di }}
                    @if (!$loop->last)
                        ,
                    @endif
                @endforeach
            @else
                {{ isset($user->custom_data[$data_field->name]) ? ($data_field->options->{$user->custom_data[$data_field->name]} ?? $user->custom_data[$data_field->name]) : '(not set)' }}
            @endif

            </p>
        @else
            <p><b>{{ $data_field->label }}:</b> {{ $user->custom_data[$data_field->name] ?? '(not set)'}}</p>
        @endif
    @endforeach
<h4>Groups</h4>
@endsection
