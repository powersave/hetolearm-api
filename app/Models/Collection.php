<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Collection extends Model
{
    use HasFactory;

    protected $fillable = ['slug', 'name', 'description', 'cover_image', 'released_at', 'is_active'];

    protected $casts = ['is_active' => 'boolean', 'released_at' => 'date'];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
