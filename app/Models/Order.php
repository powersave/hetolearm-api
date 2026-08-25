<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'email', 'phone', 'comment', 'status', 'items', 'total', 'locale'];

    protected $casts = [
        'items' => 'array',
        'total' => 'decimal:2',
    ];
}
