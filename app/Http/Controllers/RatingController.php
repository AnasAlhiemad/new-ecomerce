<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\User;
use GuzzleHttp\Promise\Create;
use App\Http\Controllers\Model;

class RatingController extends Controller
{

    public function addrating(Request $request,$id,Rating $rating,Product $product,User $user)
    {
        $product=Product::find($id);
        $user=auth()->user();
        $request->validate([
            'rate' =>['integer','required'],
            'review'=>['string']
        ]);
        Rating::add($rating,$product);
        $user->save;
        return response()->json([
            'success' => '1',
            'message' => 'Rated successfully',
        ], 200);
    }

    public function avgrate(Rating $rate)
        {
            $average= Rating::avg('rate');
 //           $average->get();
            return response()->json([
                'success' => '1',
                'average' =>$average,
                'message' => 'Average rate',
            ], 200);
             /*      foreach($rate as $rate)
            {
            $avg=0;
            $avg=$avg+$rate;
            $avgrate=$avg/$user;
            }
*/
//            $rate=Rating::with('rate')->get();
        }


    public function update(Request $request, Rating $rate,$id)
    {
     //   $id = auth()->product()->id;
        $product=Product::find($id);
        $user=auth()->user();
        $input = $request->validate([
            'rate' =>['integer','required'],
            'review'=>['string']
        ]);

        $rate->rate = $request->rate;
        // $average= Rating::avg('rate');
        $rate->update($input);
        return response()->json([
            'success' => '1',
            'rate' => $rate,
            // 'average_rate' => $average,
            'message'=>'rate updated successfully',
        ], 200);
    }

    public function myratings(Request $request,Rating $rating)
    {
        // $user1 = auth()->user();
        // $user = User::find($user1['id']);
        $user = User::find(auth()->id());

        $rating = $user->ratings()->get();

        return response()->json([
            'success' => '1',
            'data' => $rating,
        ], 200);
    }
    public function destroy(Rating $rate,$id,Product $product,User $user)
    {
        $product=Product::find($id);
        $user=auth()->user();
        if($product){
        $rate->delete();
        $user->save;
        return response()->json([
            'success' => '1',
            'message'=>'rate removed successfully',
        ], 200);
        }
    }

}
