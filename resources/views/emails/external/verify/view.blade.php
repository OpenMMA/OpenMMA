Dear {{ $external->name }}, <br>
<br>
Thank you for your registration for {{ $event->title }}.<br>
You can view the event <a href="{{ url('/event/'.$event->slug) }}">here</a> .<br>
<br>
Please verify your email address to complete your registration:<br>
<a href="{{ $link }}">Verify</a><br>
This link is valid for 24 hours.<br>
<br>
Kind regards,<br>
{{ setting('site.name') }}<br>
<br>
<br>
If the link above does not work, please copy this into your browser:<br>
{{ $link }}