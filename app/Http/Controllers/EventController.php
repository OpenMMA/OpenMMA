<?php

namespace App\Http\Controllers;

use App\Models\Events\Event;
use App\Models\Events\EventRegistration;
use App\Models\Groups\Group;
use App\Models\Image;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        return response()->view('events.calendar');
    }

    public function dashboardIndex(): Response
    {
        $events = Event::all();
        return response()->view('dashboard.events', ['events' => $events]);
    }

    public function profileIndex(): Response
    {
        // Get all events that the user is registered for
        $registrations = EventRegistration::registrationsForUser(Auth::user()->id);
        $events = array_map(fn($r) => Event::where('id', $r->event_id)->first(), $registrations);
        $upcoming_events = array_filter($events, fn($e) => $e->start > Carbon::now());
        $past_events = array_filter($events, fn($e) => $e->start < Carbon::now());
        return response()->view('profile.events', ['upcoming_events' => $upcoming_events, 'past_events' => $past_events]);
    }

    public function getevents(Request $request): JsonResponse
    {
        $start = Carbon::createFromTimestamp($request->input('start'));
        $end = Carbon::createFromTimestamp($request->input('end'));
        $events = Event::where([['start', '>=', $start], ['start', '<=', $end]])
                       ->orWhere([['end', '>=', $start], ['end', '<=', $end]])
                       ->get()->all();
        return response()->json(array_map(fn($e) => array('title' => $e->title,
                                                          'description' => $e->description,
                                                          'start' => $e->start,
                                                          'end' => $e->end,
                                                          'url' => $e->url), $events));
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event): Response
    {
        return response()->view('events.event', ['event' => $event]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Event $event): Response
    {
        return response()->view('events.edit', ['event' => $event]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Event $event, String $action): RedirectResponse|Response
    {
        if (!Auth::user()->can(Group::find($event->group)->name.'.event.edit'))
            return response("Not allowed.", 403);

        switch ($action) {
            case 'body':
                $event->update([
                    'title'       => $request->title,
                    'description' => $request->description,
                    'body'        => $request->body,
                    'start'       => $request->start,
                    'end'         => $request->end
                ]);
                break;
            case 'banner':
                $img = Image::store($request->file('banner'), 'banners');
                if ($img == null)
                    return response()->redirectTo('/event/' . $event->slug . '/edit')->with(array('action' => $action, 'status' => 'fail'));
                $event->update(['banner' => $img->id]);
                break;
            case 'tags':

                break;
            case 'max_registrations':
                $event->update([
                    'max_registrations' => $request->max_registrations
                ]);
                break;
            default:
                return response()->redirectTo('/event/' . $event->slug . '/edit')->with(array('action' => $action, 'status' => 'fail'));
        }
        return response()->redirectTo('/event/' . $event->slug . '/edit')->with(array('action' => $action, 'status' => 'updated'));
    }

    public function register(Request $request, Event $event): RedirectResponse
    {
        // TODO check if not already registered
        // TODO check if maximum number of registrations has not been reached
        if ($event->require_additional_data) {
            $keys = array_column($event->additional_data_fields, 'name');
            $additional_data = array_combine($keys, array_map(fn($key) => $request->$key, $keys));
        } else {
            $additional_data = [];
        }
        $event->register(Auth::id(), $additional_data);
        return response()->redirectTo('/event/' . $event->slug)->with(['status' => 'registered']);
    }

    public function unregister(Request $request, Event $event): RedirectResponse
    {
        $event->unregister(Auth::id());
        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event): RedirectResponse|Response
    {
        if (!Auth::user()->can(Group::find($event->group)->name.'.event.delete'))
            return response("Not allowed.", 403);

        $event->delete();
        return response()->redirectTo('/events');
    }
}
