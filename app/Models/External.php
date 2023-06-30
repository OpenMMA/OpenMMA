<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class External extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'affiliation'
    ];
}
