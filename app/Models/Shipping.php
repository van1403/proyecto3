<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shipping extends Model
{
    use HasFactory;

    protected $fillable = [
        'sale_id',
        'delivery_type',
        'address',
        'city',
        'region',
        'postal_code',
        'phone',
        'shipping_cost'
    ];

    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }
}
