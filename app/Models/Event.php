<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;


class Event extends Model
{
    use HasFactory, Sluggable;

    protected $fillable = [
        'title',
        'description',
        'body',
        'start',
        'end'
    ];

    protected $appends = ['url'];

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
}
