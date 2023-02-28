@include('header')
@pushOnce('scripts')
<script src="{{ asset('/js/calendar.js') }}"></script>
@endPushOnce
@pushOnce('styles')
<link href="{{ asset('/css/calendar.css') }}" rel="stylesheet">
@endPushOnce
<div class="container calendar-container p-3 sticky-top rounded shadow-lg" id="calendar"></div>
@include('footer')

