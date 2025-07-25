<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\OrderItem;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'total_price',
        'status',
        'created_at',
    ];

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
