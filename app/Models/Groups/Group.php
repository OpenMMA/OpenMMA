<?php

namespace App\Models\Groups;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory, Sluggable;

    protected $fillable = [
        'label',
        'category',
        'color'
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

    static function inCategory(?string $category_name): Collection
    {
        if ($category_name == null)
            return Group::where('category', null)->get();

        $category = GroupCategory::where('name', $category_name)->first();
        if ($category == null)
            return Collection::empty();

        return Group::where('category', $category->id)->get();
    }
}
