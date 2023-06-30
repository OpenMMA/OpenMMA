Dear {{ $external->name }},

Thank you for your registration for {{ $event->name }}.
You can view the event here: {{ url('/event/'.$event->slug) }}

Please verify your email address to complete your registration:
{{ $link }}
This link is valid for 24 hours.

Kind regards,
{{ setting('site.name') }}