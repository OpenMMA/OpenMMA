<?php

namespace App\Models\Groups;

use App\Traits\CSSColor;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory, Sluggable, CSSColor;

    protected $fillable = [
        'label',
        'category',
        'page'
    ];

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable(): array
    {
        return [
            'name' => [
                'source' => 'label'
            ]
        ];
    }
}
