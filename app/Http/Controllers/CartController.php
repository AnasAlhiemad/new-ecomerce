<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartOrder;
use App\Models\User;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;
class CartController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
public function CreateCart(Request $request)
{
    // $validator =validator::make($request->all(),[
    //     'my_cart' => 'required|string|between:2,100',

    //      ]);
    //    if($validator->fails())
    //    {
    //        return response()->json($validator->errors()->toJson(), 422);
    //    }
    $cart=Cart::create([
        'my_cart'=>'my_cart',
        'user_id'=>Auth::id(),
        'sub_total'=>0,
    ]);
    return response()->json(['message'=>'done create cart for you']);

}
public function getCart(){
    $cart=Cart::with('cart_order.product.image')->where('user_id',Auth::id())->get();

    return response()->json($cart);
}
public function deleteCart($cart_id){
    //$cart=Cart::where('id',$cart_id)->delete();
    $cart =Cart::find($cart_id)->delete();
    $cart =CartOrder::where('cart_id',$cart_id)->delete();
    return response()->json(['message'=>'done delete your cart']);
}

public function deleteitem($item_id){
    $cart =CartOrder::where('id',$item_id)->delete();
    return response()->json(['message'=>'done delete your item']);
}

public function Updatecart(Request $request,$item_id)
{
       $item=CartOrder::where('id',$item_id)->firstOrFail();
       $sub_total=$item->sub_total;
       $product_id=$item->product_id;
       $product=Product::where('id',$product_id)->firstOrFail();
       $price_product=$product->price_product;
       $validator = Validator::make($request->all(), [
                'quantity' => 'required',
                                                    ]);
    if ($validator->fails())
    {
        return response()->json($validator->errors()->toJson(), 400);
    }

    $newSub_total=$request->quantity*$price_product;
    $item= CartOrder::find($item_id)->update([
        'quantity'=> $request->quantity,
        'sub_total'=> $newSub_total                         ]);

        return response()->json(['message'=> 'done']);

}
}
