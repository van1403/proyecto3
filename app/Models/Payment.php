<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'sale_id',
        'method',
        'transaction_id',
        'amount',
    ];

    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }
}
