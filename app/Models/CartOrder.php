<?php

namespace App\Models;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart_Order extends Model
{
    use HasFactory;
    protected $table = "cart_orders";
    protected $fillable = [
        'cart_id','quantity','product_id'
    ];
    public function cart()
    {
        return $this->belongsTo(Cart::class,'cart_id');
    }
    public function product()
    {
        return $this->belongsTo(Product::class,'product_id');
    }
}
