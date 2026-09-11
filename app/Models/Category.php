<?php

namespace App\Models; 

use Illuminate\Support\Facades\Storage;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Category extends Model
{
protected $fillable = [
    'slug',
    'name',
    'body_part',
	  'main_image',
	  'background_opacity',
    'parent_id',
    'sort_order',
    'background_image',
    'content',
    'is_active',
];

    protected $casts = [
        'is_active' => 'boolean',
    ];
    protected static function booted()
    {
        static::updating(function ($category) {
            if ($category->isDirty('background_image') && $category->getOriginal('background_image')) {
                Storage::disk('public')->delete($category->getOriginal('background_image'));
            }
        });

        static::deleting(function ($category) {
            if ($category->background_image) {
                Storage::disk('public')->delete($category->background_image);
            }
        });
    }
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function blocks(): HasMany
    {
        return $this->hasMany(CategoryBlock::class)->orderBy('sort_order');
    }
}