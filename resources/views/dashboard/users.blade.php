@extends('dashboard.layout')

@pushOnce('scripts')
<script src="{{ asset('/js/dashboard/users.js') }}"></script>
@endPushOnce
@pushOnce('styles')
<link rel="stylesheet" href="{{ asset('/css/dashboard/users.css') }}">
@endPushOnce

@section('dashboard.content')
<div class="border-bottom">
    <h2 class="pt-3 pb-2">Users</h2>
</div>
<div class="pt-3 px-3">
    <table class="table table-striped" id="user_table">
        <thead>
            <tr>
                <th scope="col" width="8%">First name</th>
                <th scope="col" width="12%">Last name</th>
                <th scope="col" width="20%">Email address</th>
                <th scope="col" width="5">Email verified</th>
                <th scope="col" width="">Registered</th>
                <th scope="col" width="1%"></th>
                <th scope="col" width="1%"></th>
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
                <td>{{ $user->created_at }}</td>
                <td class="text-center">
                @if($user->user_verified_at)
                    <i class="fa-solid fa-check text-success"></i>
                @else
                @include('components.form', ['form_name' => 'verify_user_form_' . $user->id,
                                             'form_submit' => 'Verify',
                                             'form_target' => "/user/$user->id/verify",
                                             'form_submit_classes' => 'btn btn-warning px-1 py-0',
                                             'form_fields' => []])
                @endif
                </td>
                <td class="hide"><a href="{{ url("/dashboard/user/$user->id") }}" class="btn btn-primary px-1 py-0">View</a></td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @push('scripts')
    <script>
        $(document).ready(() => {
            @foreach($users as $user)
                @if(!$user->user_verified_at)
                    $('#verify_user_form_{{ $user->id }}').submit(verificationAJAX);
                @endif
            @endforeach
        });
    </script>
    @endpush
</div>
@endsection
