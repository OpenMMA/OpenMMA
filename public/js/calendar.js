function registerEventTriggers() {
    events = $('a.event').map(function() { return $(this).attr('event-id'); });
    new Set(events).forEach((e) => {
        $(`[event-id=${e}]`).hover(() => $(`[event-id=${e}]`).addClass('event-hover'),
                                   () => $(`[event-id=${e}]`).removeClass('event-hover'));

    });
}

$(document).ready(() => {
    registerEventTriggers();
    Livewire.hook('message.processed', () => { registerEventTriggers() });
});
