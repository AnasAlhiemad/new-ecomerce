<?php

namespace App\Models;
use App\Models\User;
use App\Models\Order;
use App\Models\Prduct;
use App\Models\CartOrder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    protected $table = "carts";
    protected $fillable =
    [
        'user_id','my_cart'
        //,'product_id','quantity','sub_total'
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
        return $this->hasMany(CartOrder::class,'cart_id');
    }
    public function order()
    {
        return $this->hasMany(Order::class,'cart_id');
    }


}
