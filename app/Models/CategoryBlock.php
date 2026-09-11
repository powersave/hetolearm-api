<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class CategoryBlock extends Model
{
    protected $fillable = [
        'category_id',
        'title',
        'description',
        'image',
        'sort_order',
    ];

    protected static function booted()
    {
        // Удаляем файл при удалении записи
        static::deleting(function ($block) {
            if ($block->image) {
                Storage::disk('public')->delete($block->image);
            }
        });

        // Удаляем старый файл при обновлении записи с новым изображением
        static::updating(function ($block) {
            if ($block->isDirty('image') && $block->getOriginal('image')) {
                Storage::disk('public')->delete($block->getOriginal('image'));
            }
        });
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}