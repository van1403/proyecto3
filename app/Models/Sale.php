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
    'delivery_method',
    'address',
    'payment_method',
    ];

    // 👤 Relación con el usuario que realizó la compra
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // 🧾 Relación con los productos comprados
    public function items()
    {
        return $this->hasMany(SaleItem::class);
    }

    // 💳 Si tienes tabla separada de pagos (opcional)
    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    // 🚚 Si tienes tabla separada de envíos (opcional)
    public function shipping()
    {
        return $this->hasOne(Shipping::class);
    }
}
