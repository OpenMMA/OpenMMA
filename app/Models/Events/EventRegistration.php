<?php

namespace App\Models\Events;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class EventRegistration extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'external_id',
        'event_id',
        'data'
    ];
    protected $casts = [
        'data' => 'json'
    ];

    /**
     * Return a list with the registrations for a given user
     */
    public static function registrationsForUser($user_id): array
    {
        return EventRegistration::where(['user_id' => $user_id])->get()->all();
    }

    /**
     * Return a list with the registrations for a given event
     */
    public static function registrationsForEvent($event_id): array
    {
        return EventRegistration::where(['event_id' => $event_id])->get()->all();
    }

    /**
     * Check if a given user has registered for a given event,
     * and return the registration if this is the case
     */
    public static function userRegistrationForEvent($user_id, $event_id): ?EventRegistration
    {
        if (!$user_id)
            return null;
        return EventRegistration::where(['user_id' => $user_id, 'event_id' => $event_id])->first();
    }

    public function scopeInternal(Builder $query): void
    {
        $query->where('user_id', '!=', 'null');
    }
    public function scopeExternal(Builder $query): void
    {
        $query->where('external_id', '!=', 'null');
    }
}
