<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medicine extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'image_url',
        'description',
        'price',
        'quantity',
        'category',
        'manufacturer',
        'expiry_date',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'quantity' => 'integer',
        'expiry_date' => 'date',
    ];
}

