<?php

namespace App\Models\Tags;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'label',
        'color',
    ];

    public function hex(): Attribute
    {
        return Attribute::make(
            get: fn($v, $attrs) => '#'.str_pad(dechex($attrs['color']), ($attrs['color'] > 0xffffff ? 8 : 6), '0', STR_PAD_LEFT),
            set: fn(string $v) => ['color' => hexdec(substr($v, 1))]
        );
    }

    public function RGB()
    {
        return Attribute::make(
            get: fn($v, $attrs) => ($attrs['color'] > 0xffffff) ? 
                [($attrs['color'] >> 24) & 0xff, ($attrs['color'] >> 16) & 0xff, ($attrs['color'] >> 8) & 0xff, ($attrs['color'] & 0xff) / 0xff] :
                [($attrs['color'] >> 16) & 0xff, ($attrs['color'] >> 8) & 0xff, ($attrs['color'] & 0xff)],
            set: fn(array $v) => ['color' => (sizeof($v) == 4) ? 
                [$v[0] << 24, $v[1] << 16, $v[2] << 8, (int)($v[3] * 0xff)] :
                [$v[0] << 16, $v[1] << 8, $v[2]]
            ]
        );
    }
}
