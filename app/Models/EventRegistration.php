<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventRegistration extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'event_id',
        'data'
    ];

    /**
     * Return a list with the registrations for a given user
     */
    public static function registrationsForUser($user_id): array
    {
        return EventRegistration::where(['user_id' => $user_id])->all();
    }

    /**
     * Return a list with the registrations for a given event
     */
    public static function registrationsForEvent($event_id): array
    {
        return EventRegistration::where(['event_id' => $event_id])->all();
    }
    
    /**
     * Check if a given user has registered for a given event, 
     * and return the registration if this is the case
     */
    public static function userRegistrationForEvent($user_id, $event_id): EventRegistration
    {
        return EventRegistration::where(['user_id' => $user_id, 'event_id' => $event_id])->first();
    }
}
