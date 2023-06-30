<div class="card">
    @if ($event->registerable)
        <div class="card-header">
            Register for this event {{ $event->allow_externals ? 'as external' : '' }}
        </div>
        @guest
        @if (!$event->allow_externals)
            <div class="card-body bg-primary-subtle text-primary">
                You need to be logged in to register.
            </div>
        @endif
        @endguest

        @if (Auth::check() || $event->allow_externals)
            @if ($registered || \App\Models\Events\EventRegistration::userRegistrationForEvent(Auth::id(), $event->id))
                <div class="card-body bg-success-subtle text-success">
                    You have registered for this event!
                    @if (!Auth::check())
                        You will receive a verification link to complete your registration.
                    @endif
                </div>
            @else
                <div class="card-body">
                    <form wire:submit.prevent="register">
                        @if (!Auth::check())
                            <div class="mb-2">
                                <small>If you are a member, please <a href="/login">log in</a> to register.</small>
                            </div>
                        @endif
                        @if ($event->max_registrations > 0)
                            @php
                                $places_left = max([0, $event->max_registrations - sizeof($event->registrations)]);
                            @endphp
                            <small>Max. {{ $event->max_registrations }} participants, <b>{{ $places_left }}</b> place{{ $places_left == 1 ? '' : 's' }} left</small><br>
                        @else
                            @php
                                $places_left = 1;
                            @endphp
                        @endif
                        @if ($places_left > 0 || $event->queueable)
                            @if ($places_left == 0)
                                The event is full, but you can register to queue if places become available.
                            @endif
                            @csrf
                            @if (!Auth::check())
                                <div>
                                    <div class="mb-3">
                                        <label class="form-label" for="external_name">Full name</label>
                                        <input wire:model.defer="external.name" class="form-control" type="text" id="external_name" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="external_email">Email address</label>
                                        <input wire:model.defer="external.email" class="form-control" type="email" id="external_email" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="external_affiliation">Affiliation (optional)</label>
                                        <input wire:model.defer="external.affiliation" class="form-control" type="text" id="external_affiliation">
                                    </div>
                                </div>
                                <hr>
                            @endif
                            @if ($event->require_additional_data)
                                @include('components.form.form-fields', ['fields' => array_map(function($v) { $v['wire'] = 'additional_data.'.$v['name']; return (object)$v; }, $event->additional_data_fields)])
                                <hr>
                            @endif
                            <button type="submit" class="btn btn-primary">{{ $places_left > 0 ? "Register" : "Enter queue" }}</button>
                        @else
                            The event is full. Registering is not possible unless places become available.
                        @endif
                    </form>
                </div>
                @endif
            @endif
    @else
        <div class="card-body">
            Registering for this event is not possible.
        </div>
    @endif
</div>
