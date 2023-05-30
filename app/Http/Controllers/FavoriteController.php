<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Favorite;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class FavoritController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function addFavorite($productId)
    {
        $user = User::where('id',Auth::id())->firstOrFail();
        $user_id=$user->id;
        $favorit=Favorite::create([
            'user_id'=>$user_id,
            'product_id'=>$productId
        ]);
        return response()->json(['message'=>'done']);

    }
    public function get_myFavorite()
    {
        $myFavorit=Favorite::with('product')->get();
        return response()->json($myFavorit);
    }

    public function delete_favorite($IdFavorite){
        $favorite=Favorite::find($IdFavorite)->delete();
        return response()->json(['message'=>'done delete']);
    }


}
