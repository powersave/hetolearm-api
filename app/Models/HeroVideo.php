<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HeroVideo extends Model
{
    protected $fillable = [
        'title',
        'video_url',
        'video_file',
        'video_file_r2',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}