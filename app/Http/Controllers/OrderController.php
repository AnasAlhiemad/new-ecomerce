<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Cart;
use App\Models\User;
use App\Models\CartOrder;
use App\Models\Product;
use Illuminate\Http\Request;
use Notifiable;
use Illuminate\Support\Facades\Auth;
use App\Notifications\NewNotification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Notifications\Messages\MailMessage;
class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    public function addOrder()
    {
      $id=Auth::user();
      $purchaser=User::where('id',$id)->firstOrFail();
      $purchaser_name=$purchaser->name;
      $purchaser_number=$purchaser->number;
      $cart=Cart::where('user_id',$id)->firstOrFail();
      $cart_id=$cart->id;
      $items_order=CartOrder::where('cart_id',$cart_id)->get();
      foreach ($items_order as $item_order) {
        $product_id=$item_order->product_id;
        $quantity=$item_order->quantity;
        $product=Product::where('id',$product_id)->firstOrFail();
        $recip_id=$product->user_id;
        $product_name=$product->product_name;
        $order=Order::create([
            'date'=> now(),
            'cart_id'=>$cart_id,
            'recip_id'=>$recip_id,
        ]);
            $user = User::find($recip_id);
            $line="Buyer is:{{$purchaser_name}}his phone:{{$purchaser_number}}
            want to buy your product{{$product_name}} with quantity:{{$quantity}}";
            $notification = new NewNotification($line);
            $user->notify($notification);
            $notification1 = new NewNotification();
            $id->notify($notification1);
      }
    return response()->json(['message'=>'done send your ordre']);
     }
     public function cancelorder(){

     }
    }
