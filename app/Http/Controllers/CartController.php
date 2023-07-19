<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartOrder;
use App\Models\User;
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
    $user=Cart::with('cart_order.product')->where('id',Auth::id())->get();
    return response()->json($user);
}
}
