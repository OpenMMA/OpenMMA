<?php

namespace App\Http\Controllers;

use App\Mail\ExternalVerified;
use App\Models\Events\Event;
use App\Models\Events\EventRegistration;
use App\Models\External;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Mail;

class ExternalEmailVerificationController extends Controller
{
    public function __invoke(Request $request)
    {
        if (!$request->hasValidSignature())
            abort(401);

        $external = External::find($request->id);

        if (!$external || $request->hash !== sha1($external->email))
            abort(401);

        $event = Event::find(EventRegistration::where(['external_id' => $external->id])->first()->event_id);
        if (!$external->email_verified_at) {
            $external->forceFill(['email_verified_at' => Date::now()])->save();
            Mail::to($external->email)->send(new ExternalVerified($external, $event));
        }

        $request->session()->flash('alert-success', 'Your email address was verified successfully!');
        return redirect('/event/' . $event->slug);
    }
}
