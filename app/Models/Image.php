<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rules\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class Image extends Model
{
    use HasFactory;

    protected $fillable = [
        'path',
        'external',  // TODO is this not a security risk? If external URL is directly settable but external is false, may it be used to retrieve arbitrary files?
        'uploader_id',
    ];

    public static function store($file, $folder='img')
    {
        $validator = Validator::make(['file' => $file], ['file' => [File::image()]]);
        if ($validator->fails()) {
            return null;
        }
        $path = $file->store($folder);
        return Image::create([
            'path' => $path,
            'external' => false,
            'uploader_id' => Auth::id()
        ]);
    }

    public function getUrlAttribute()
    {
        return $this->external ? $this->path : url($this->path);
    }
}
