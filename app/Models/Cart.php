<?php

namespace App\Models;
use App\Models\User;
use App\Models\Prduct;
use App\Models\Cart_Order;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    protected $table = "carts";
    protected $fillable =
    [
        'user_id','total','my_cart'
        //,'product_id','quantity'
    ];


    public function products() {
        return $this->hasMany(Product::class, 'product_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function cart_order()
    {
        return $this->hasMany(Cart_Order::class, 'cart_id');
    }


}
