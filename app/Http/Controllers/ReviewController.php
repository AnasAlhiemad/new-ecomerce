<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\User;
use Auth;
use Validator;
class ReviewController extends Controller
{
    public function addreview(Request $request,$id)
    {
        $validator =validator::make($request->all(),[
            'reviews'=>'required|string',
                                               ]);
          if($validator->fails())
          {
           return response()->json($validator->errors()->toJson(), 422);
          }

    $review=Review::create([
     'reviews' => $request->reviews,
     'product_id'=> $id,
     'user_id'=>Auth::id(),
                         ]);
     return response()->json([
        'success' => '1',
        'message' => 'review successfully',
        ], 200);
    }
    public function getReview($id)
    {
        $review=Review::where('product_id',$id)->get();
        return response()->json([
            'success' => '1',
            'review' =>$review,
        ], 200);}
        public function update(Request $request,$id)
        {
            $review=Review::where('id',$id)->update([
                'reviews' => $request->reviews,
             ]);

            return response()->json([
                'success' => '1',
                'message'=>'review updated successfully',
            ], 200);
        }
        public function delete($id)
        {
            $review=Review::where('id',$id)->delete();
            return response()->json([
                'success' => '1',
                'message'=>'review removed successfully',
            ], 200);

        }
}
