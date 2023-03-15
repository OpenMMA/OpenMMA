<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;


class ImageController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $event = Image::create([
            'title'       => $request->title,
            'description' => "",
            'body'        => ""
        ]);

        return response()->redirectTo('/event/' . $event->slug . '/edit');
    }
}
