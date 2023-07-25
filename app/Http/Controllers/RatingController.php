<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\User;
use Validator;
use Auth;
use GuzzleHttp\Promise\Create;
use App\Http\Controllers\Model;

class RatingController extends Controller
{

    public function addrating(Request $request,$id)
    {
        // $validator =validator::make($request->all(),[
        //     'rate'=>'required|integer',
        //     'reviews'=>'required|string'
        //                                        ]);
        //   if($validator->fails())
        //   {
        //    return response()->json($validator->errors()->toJson(), 422);
        //   }

     //   return $request->rate;
    $rate=Rating::create([
     'rate' => $request->rate,
     'reviews' => $request->reviews,
     'product_id'=> $id,
     'user_id'=>Auth::id(),
                         ]);
     return response()->json([
        'success' => '1',
        'message' => 'Rated and reviews successfully',
        ], 200);
    }

    public function getRate($id)
        {
           // $average= Rating::where('product_id',$id)->avg('rate');
            $review= Rating::with('user')->where('product_id',$id)->get();
            return response()->json($review);
        }
    public function getaverage($id)
        {
            $average= Rating::where('product_id',$id)->avg('rate');
            return response()->json($average);
        }


    public function update(Request $request,$id)
    {

         $rate=Rating::where('product_id',$id)->update([
            'rate' => $request->rate,
         ]);

        return response()->json([
            'success' => '1',

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
    public function delete($id)
    {
        $rate=Rating::where('product_id',$id)->delete();
        return response()->json([
            'success' => '1',
            'message'=>'rate removed successfully',
        ], 200);

    }

}
