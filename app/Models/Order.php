<?php

namespace App\Models;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Cart;
class Order extends Model
{
    use HasFactory;
    protected $table = "orders";
    protected $fillable = [
        'date',
        'status',
        'cart_id',
        'recip_id'
    ];
    public function cart()
    {
        return $this->belongsTo(Cart::class,'cart_id');
    }
    public function recip()
    {
        return $this->belongsTo(User::class,'recip_id');
    }
}
