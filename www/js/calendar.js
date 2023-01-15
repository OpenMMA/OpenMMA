var date = new Date();
$(document).ready(() => {
    let calendar = new Calendar($("#calendar"));
    calendar.render();
});
const months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
const days_short = ["MON", "TUE", "WED", "THU", "FRI", "SAT", "SUN"];
const days_long = ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"];

class Calendar {
    constructor(c) {
        this.container = c;
        this.date = new Date();
        this.date_base = this._getFirstDay();

        // Add header (static)
        c.append("<div class=\"container text-center\"><div class=\"row justify-content-center m-3\"><div class=\"col-1\" id=\"cal-prev\"><p class=\"cal-arrow cal-arrow-l mt-3\"></p></div><div class=\"col-3 fs-5 fw-semibold\" id=\"monthyear\"></div><div class=\"col-1\" id=\"cal-next\"><p class=\"cal-arrow cal-arrow-r mt-3\"></p></div></div><div class=\"col-12 border-top border-secondary-subtle\"></div></div>");

        // Add day labels
        let days_header = $(this._create('div')).addClass("calendar-days-header text-center fs-6 text-secondary");
        for (let day of days_short) {
            days_header.append($(this._create('div')).append($(this._create('p')).addClass("m-2").text(day)));
        }
        c.append(days_header);

        // Add calendar cells
        let cells = $(this._create('div')).addClass("calendar-days text-secondary");
        for (let i = 0; i < 42; i++) {
            let cell = $(this._create('div')).addClass("day container p-0").attr("id", "day-" + i).css({"z-index": 42 - i});
            cell.append($(this._create('span')));
            cells.append(cell);
        }
        c.append(cells);

        c.find("#cal-prev").click(() => this.updateMonth(-1));
        c.find("#cal-next").click(() => this.updateMonth(1));
    }

    /**
     *  Shorthand for document.createElement()
     */
    _create = (el) => document.createElement(el);

    /**
     *  Adjust for weeks starting on sunday
     */
    _weekdayAdjust = (day) => (day + 6) % 7;

    /**
     *
     */
    // _roundDay = (day) => new Date((Math.round(day.valueOf() / 86400000) * 86400000));
    _roundDay = (day) => new Date(day.getFullYear(), day.getMonth(), day.getDate());

    /**
     *  Get difference in days between two given dates
     */
    _daysDiff = (d1, d2) => Math.ceil((this._roundDay(d2) - this._roundDay(d1)) / (1000 * 60 * 60 * 24));

    /**
     *  Get the first day of the calendar this date should be on
     */
    _getFirstDay() {
        // Find the first day of the month
        let start = new Date(this.date.getFullYear(), this.date.getMonth(), 1);
        // Set date to first day of the week (adjust for 0 = sunday to 0 = monday)
        start.setDate(-this._weekdayAdjust(start.getDay()) + 1);
        return start;
    }

    /**
     *
     */
    _padNum = (n) => (n >= 0 && n < 10) ? '0' + n : '' + n

    /**
     *
     */
    _formatDate = (d) => `${this._padNum(d.getDate())}/${this._padNum(d.getMonth()+1)}/${d.getFullYear()} ${this._padNum(d.getHours())}:${this._padNum(d.getMinutes())}`;

    /**
     *  Change the displayed month by the given offset
     */
    updateMonth(amt) {
        this.date.setMonth(this.date.getMonth() + amt);
        this.date_base = this._getFirstDay();
        this.render();
    }


    /**
     *  Render the calendar, including all relevant events.
     */
    render() {
        let events = [{
            'title': "Testing Event Lorem Ipsum",
            'desc': "Lorem ipsum dolor sit amet, consecutor.",
            'id': 0,
            'start': new Date("Jan 5, 2023 11:00"),
            'end': new Date("Jan 7, 2023 10:00"),
            'color': 5,
            'offset': 1
        }, {
            'title': "Christmas!!!",
            'desc': "Lorem ipsum dolor sit amet, consecutor.",
            'id': 1,
            'start': new Date("Dec 25, 2022"),
            'end': new Date("Dec 26, 2022 23:59"),
            'color': 3,
            'offset': 1
        }, {
            'title': "Single-day Event",
            'desc': "Lorem ipsum dolor sit amet, consecutor.",
            'id': 2,
            'start': new Date("Jan 12, 2023 17:00"),
            'end': new Date("Jan 12, 2023 19:00"),
            'color': 2,
            'offset': 1
        }];
        this.renderCalendar();
        this.resetEvents();
        for (let event of events) {
            this.renderEvent(event);
        }
    }

    /**
     *
     */
    registerEventHover(s) {
        $(`[event-id=${s}]`).hover(() => $(`[event-id=${s}]`).addClass('event-hover'),
                                   () => $(`[event-id=${s}]`).removeClass('event-hover'));
    }

    /**
     *  Render the days of the given month and set all
     *  days outside the current month to 'inactive'.
     */
    renderCalendar() {
        $("#monthyear").text(months[this.date.getMonth()] + " " + this.date.getFullYear());

        let curr = new Date(this.date_base);
        for (let d = 0; d < 42; d++) {
            let el = $("#day-" + d);
            el.children("span").text(curr.getDate());
            if (curr.getMonth() == this.date.getMonth()) {
                el.removeClass("inactive");
            } else {
                el.addClass("inactive");
            }
            curr.setDate(curr.getDate() + 1);
        }
    }

    /**
     *
     */
    resetEvents() {
        this.container.find(".event").remove();
    }

    /**
     *  Render a given event, if it is on the current calendar.
     */
    renderEvent(event) {
        let event_start = this._daysDiff(this.date_base, event.start);
        let event_end = this._daysDiff(this.date_base, event.end);
        console.log(event_start, event_end);

        // Exit if event is outside calendar range
        if (event_start > 42 || event_end < 0) {
            return;
        }

        // TODO better coloring system
        let color = `event-c${event.color}`;
        let offset = `event-p${event.offset}`;

        // Prepare text elements
        let desc_h = $(this._create('p')).addClass('event-desc-date fw-semibold').append($(this._create('small')).text(`${this._formatDate(event.start)} - ${this._formatDate(event.end)}`));
        let desc_c = $(this._create('p')).addClass('event-desc-text').text(event.desc);
        let desc = $(this._create('div')).append(desc_h).append(desc_c).html();
        let text = $(this._create('p')).text(event.title);

        if (event_start == event_end) {
            let e = $(this._create('a')).addClass(`event ${color} event-single ${offset}`).append(text);
            e.attr({'event-id': `e${event.id}`,
                    'tabindex': 0,
                    'role': "button",
                    'data-bs-toggle': "popover",
                    'data-bs-trigger': "focus",
                    'data-bs-placement': "bottom",
                    'data-bs-title': event.title});
            new bootstrap.Popover(e, {'trigger': "focus", 'html': true, 'content': desc});
            this.container.find(`#day-${event_start}`).append(e);
        } else {
            for (let i = event_start; i <= event_end; i++) {
                let e = $(this._create('a')).addClass(`event ${color} ${offset}`);
                e.attr({'event-id': `e${event.id}`,
                        'tabindex': 0,
                        'role': "button",
                        'data-bs-toggle': "popover",
                        'data-bs-trigger': "focus",
                        'data-bs-placement': "bottom",
                        'data-bs-title': event.title});
                new bootstrap.Popover(e, {'trigger': "focus", 'html': true, 'content': desc});
                if (i == event_start) {
                    e.addClass("event-start").append(text);
                } else if (i == event_end) {
                    e.addClass("event-end");
                } else {
                    e.addClass("event-middle");
                }
                this.container.find(`#day-${i}`).append(e);
            }
        }
        this.registerEventHover(`e${event.id}`);
    }
}
