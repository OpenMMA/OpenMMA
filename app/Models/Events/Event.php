<?php

namespace App\Models\Events;

use App\Models\Events\EventRegistration;
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
        'registerable',
        'enable_comments',
        'max_registrations',
        'allow_externals',
        'only_allow_groups',
        'status',
        'visibility',
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

    public function getUrlAttribute()
    {
        return url("/event/{$this->slug}");
    }

    public function getBannerUrlAttribute()
    {
        return Image::find($this->banner)->url;
    }

    public function getRelativeWhenAttribute()
    {
        return Carbon::parse($this->start)->diffForHumans();
    }
}
