<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Medicine extends Model
{
    protected $fillable = [
        'name',
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

