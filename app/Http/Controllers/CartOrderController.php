<?php

namespace App\Http\Controllers;
use App\Models\CartOrder;
use App\Models\Cart;
use App\Models\User;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;
class CartOrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    public function addOrder(Request $request,$product_id)
    {
        $user_cart = auth()->user()->cart;
        $user_cart_id=$user_cart->id;
        $product=Product::where('id',$product_id)->firstOrFail();
        $sub_Price= $user_cart->sub_total;
        $Newsubtotal_Price=$sub_Price + ($product->price_product*$request->quantity);
        $order=CartOrder::create([
            'cart_id'=>$user_cart->id,
            'quantity'=> $request->quantity,
            'product_id'=>$product_id,
            'sub_total'=>$Newsubtotal_Price,

        ]);
        // $product=Product::where('id',$product_id)->firstOrFail();
        // $sub_Price= $user_cart->sub_total;
        // $Newsubtotal_Price=$sub_Price + ($product->price_product*$order->quantity);
        // $cart=Cart::find($user_cart_id);
        // $cart->update([
        //     'sub_total'=>$Newsubtotal_Price,
        // ]);

     return response()->json(['message'=>'done added to your cart']);
    }
    
}
