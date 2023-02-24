<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        //
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
        //
    }
}
