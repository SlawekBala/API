<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['user_id', 'status'];

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getOrderProducts() {
        return $this
            ->orderItems()
            ->select('order_items.*', 'products.name')
            ->leftJoin('products', 'order_items.product_id', '=', 'products.id')
            ->get();
    }
}
