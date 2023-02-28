<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Carbon\Carbon;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        
        return response()->view('events.calendar');
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
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return response()->view('events.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $event = Event::create([
            'title'       => $request->title,
            'description' => "",
            'body'        => ""
        ]);

        return response()->redirectTo('/event/' . $event->slug . '/edit');
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
    public function update(Request $request, Event $event): RedirectResponse
    {
        $event->update([
            'title'       => $request->title,
            'description' => $request->description,
            'body'        => $request->body,
            'start'       => $request->start,
            'end'         => $request->end
        ]);
        return response()->redirectTo('/event/' . $event->slug . '/edit')->with(array('status' => 'updated'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event): RedirectResponse
    {
        $event->delete();
        return response()->redirectTo('/events');
    }
}
