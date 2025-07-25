<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'price',
        'stock',
        'category',
        'description',
        'image',
    ];
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'product_id');
    }
        public function cartitems()
    {
        return $this->hasMany(CartItem::class, 'product_id');
    }

}
