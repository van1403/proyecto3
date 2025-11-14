<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'total_amount',
    ];

    // 👤 Usuario que realizó la compra
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // 🧾 Productos comprados
    public function items()
    {
        return $this->hasMany(SaleItem::class);
    }

    // 💳 Información del pago (relación 1:1)
    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    // 🚚 Información del envío (relación 1:1)
    public function shipping()
    {
        return $this->hasOne(Shipping::class);
    }
}
