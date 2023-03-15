<?php

namespace App\Models;

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
        'banner'
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
