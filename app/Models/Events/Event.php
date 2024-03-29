<?php

namespace App\Models\Events;

use App\Models\Color;
use App\Models\Events\EventRegistration;
use App\Models\Groups\Group;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Cviebrock\EloquentSluggable\Sluggable;
use App\Models\Image;

class Event extends Model
{
    use HasFactory, Sluggable;

    protected $fillable = [
        'title',
        'description',
        'body',
        'start',
        'end',
        'banner',
        'group',
        'color',
        'registerable',
        'require_additional_data',
        'additional_data_fields',
        'max_registrations',
        'queueable',
        'allow_externals',
        'only_allow_groups',
        'status',
        'visibility',
    ];

    protected $casts = [
        'start' => 'datetime',
        'end' => 'datetime',
        'additional_data_fields' => 'json'
    ];

    protected $appends = ['url'];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('order', function (Builder $builder) {
            $builder->orderBy('start', 'asc');
        });
    }

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    public function register($user_id, $data=[])
    {
        return EventRegistration::create([
            'event_id' => $this->id,
            'user_id'  => $user_id,
            'data'     => json_encode($data)
        ]);
    }

    public function unregister($user_id)
    {
        EventRegistration::where(['user_id' =>$user_id, 'event_id' => $this->id])->delete();
    }

    public function getUrlAttribute()
    {
        return url("/event/{$this->slug}");
    }

    public function getBannerUrlAttribute()
    {
        return Image::find($this->banner)?->url ?? '';
    }

    public function getRelativeWhenAttribute()
    {
        return Carbon::parse($this->start)->diffForHumans();
    }

    public function getTimeRangeAttribute()
    {
        return $this->start->diffInDays($this->end) == 0 ?
            $this->start->format('D d M H:i') . ' - ' . $this->end->format('H:i') :
            $this->start->format('D d M H:i') . ' - ' . $this->end->format('D d M H:i');
    }

    public function getGroupNameAttribute(): string
    {
        return Group::find($this->group)->name;
    }

    public function getGroupLabelAttribute(): string
    {
        return Group::find($this->group)->label;
    }

    public function getColorAttribute(): int
    {
        return $this->color ?? Group::find($this->group)->color;
    }

    /**
     * Get all registrations, including queued entries
     */
    public function getAllRegistrationsAttribute(): array
    {
        return EventRegistration::where(['event_id' => $this->id])->get()->all();
    }

    /**
     * Get registrations, without queued entries
     */
    public function getRegistrationsAttribute(): array
    {
        $registrations = EventRegistration::where(['event_id' => $this->id])->orderBy('created_at', 'asc');
        return ($this->max_registrations > 0) ?
            $registrations->take($this->max_registrations)->get()->all() :
            $registrations->get()->all();
    }

    /**
     * Get queued registration entries
     */
    public function getQueueAttribute(): array
    {
        return ($this->max_registrations > 0) ?
            EventRegistration::where(['event_id' => $this->id])
                             ->orderBy('created_at', 'asc')
                             ->skip($this->max_registrations)->get()->all() :
            [];
    }
}
