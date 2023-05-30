<?php

namespace App\Http\Controllers;
use App\Models\Cart;
use App\Models\User;
use App\Models\Product;
use App\Models\Cart_Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;
class CartOrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    public function addOrder($product_id)
    {
        $user_cart = auth()->user()->cart;
        $user_cart_id=$user_cart->id;
        $order=Cart_Order::create([
            'cart_id'=>$user_cart->id,
            'quantity'=>1,
            'product_id'=>$product_id,

        ]);
        $product=Product::where('id',$product_id)->firstOrFail();
        $total_Price= $user_cart->total;
        $Newtotal_Price=$total_Price + $product->price_product;
        $cart=Cart::find($user_cart_id);
        $cart->update([
            'total'=>$Newtotal_Price,
        ]);

return response()->json(['message'=>'done added to your cart']);
    }
}
