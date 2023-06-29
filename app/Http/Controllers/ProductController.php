<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\User;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Product;
use App\Models\Image;
use App\Http\Controllers\ImageController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

class ProductController extends Controller
{
    public function __construct()
        {
            $this->middleware('auth:api');
        }





    public function add_product(Request $request)
    {
        $validator =validator::make($request->all(),[
            'product_name' => 'required|string|between:2,100',
            'price_product'=>'required|integer',
            'category_name'=>'required|string',
            'sub_category'=>'required|string',
            'description'=>'required|string',
            'count'=>'required|integer',

                                                        ]);



        if($validator->fails())
        {
               return response()->json($validator->errors()->toJson(), 422);
        }




        $user = User::where('id',Auth::id())->firstOrFail();
        $categories=Category::all();
        $categ_isExist = false;
        $sub_categories=SubCategory::all();
        $sub_isExist=false;

        foreach($categories as $category)
        {
            if($category->category_name==$request->category_name)
            {
                    $old_categoryId=$category->id;
                    foreach($sub_categories as $sub_category)
                    {

                        if($sub_category->sub_category==$request->sub_category)
                        {
                            $old_sub_category_id=$sub_category->id;


                            $product=Product::create([
                                'product_name'=>$request->product_name,
                                'price_product'=>$request->price_product,
                                'user_id'=>$user->id,
                                'subcategory_id'=>$old_sub_category_id,
                                'views'=> 0,
                                'description'=>$request->description,
                                'count'=>$request->count,

                                                        ]);



                        $images=$request->list_images;
                        $input=[];
                        $i1=0;$i2=0;
                        foreach ($images as $image2)
                        {
                            $image1=$image2['image'];
                            $image_name=time().$image1->getClientOriginalName();
                            $image1->move(public_path('upload'),$image_name);
                            $path="upload/$image_name";
                            $input[$i1]=$path;

                            $image=Image::Create([
                                'image'=>$input[$i1],
                                'Product_id'=>$product->id,
                                            ]);
                            $i1++;
                        }


                $sub_isExist=true;
                $product=Product::where('id',$product->id)
                ->with('subcategory.category','image','ratings.user','reviews.user')->get();
                $messag='success store';
                return response()->json([$product,$messag]);
                // this is new return
                // $image=Product::find($product->id)->Image;
                // return response()->json([
                //     'category'=> $category,
                //     'sub_category'=> $sub_category,
                //     'product'=>$product,
                //     'images'=> $image,
                //     'message' => 'success store',
                //                         ]);
                     }
                }



            $new_sub_category=SubCategory::create([
                'sub_category'=>$request->sub_category,
                'category_id'=>$old_categoryId,
                                                ]);




            $product=Product::create([

                    'product_name'=>$request->product_name,
                    'price_product'=>$request->price_product,
                    'user_id'=> $user->id,
                    'subcategory_id'=>$new_sub_category->id,
                    'views'=> 0,
                    'description'=>$request->description,
                    'count'=>$request->count,
                                        ]);




            $images=$request->list_images;
            $input=[];
            $i1=0;$i2=0;
            foreach ($images as $image2)
            {
                    $image1=$image2['image'];
                    $image_name=time().$image1->getClientOriginalName();
                    $image1->move(public_path('upload'),$image_name);
                    $path="upload/$image_name";
                    $input[$i1]=$path;
                    $image=Image::Create([
                        'image'=>$input[$i1],
                        'Product_id'=>$product->id,
                                            ]);
                    $i1++;
            }



            $product=Product::where('id',$product->id)
            ->with('subcategory.category','image','ratings.user','reviews.user')->get();
            $messag='success store';
            return response()->json([$product,$messag]);

            // $image=Product::find($product->id)->Image;
            // return response()->json([
            //     'category'=> $category,
            //     'sub_category'=> $new_sub_category,
            //     'product'=>$product,
            //     'images'=>$image,
            //     'message' => 'success store',
            //                         ]);

            $categ_isExist = true;
                }
                }
#################################################################
        if($categ_isExist==false)
        {

        $new_category=Category::create([
               'category_name'=>$request->category_name,
                                    ]);


        $new_category_id=$new_category->id;
        $new_sub_category=SubCategory::create([
             'sub_category'=>$request->sub_category,
             'category_id'=> $new_category_id,
                                            ]);


        $product=Product::create([
            'product_name'=>$request->product_name,
            'price_product'=>$request->price_product,
            'user_id'=>$user->id,
            'views'=> 0,
            'subcategory_id'=>$new_sub_category->id,
            'description'=>$request->description,
            'count'=>$request->count,
                                ]);


        $images=$request->list_images;
        $input=[];
        $i1=0;$i2=0;
        foreach ($images as $image2)
        {
                $image1=$image2['image'];
                $image_name=time().$image1->getClientOriginalName();
                $image1->move(public_path('upload'),$image_name);
                $path="upload/$image_name";
                $input[$i1]=$path;
                $image=Image::Create([
                    'image'=>$input[$i1],
                    'Product_id'=>$product->id,
                                    ]);
                $i1++;

        }


        //$image=Product::find($product->id)->Image;//->get();
        $product=Product::where('id',$product->id)
        ->with('subcategory.category','image','ratings.user','reviews.user')->get();
        $messag='success store';
        return response()->json([$product,$messag]);
        // return response()->json([
        //             'category'=>$new_category,
        //             'sub_category'=>$new_sub_category,
        //             'product'=>$product,
        //             'images'=>$image,
        //             'message' => 'success store',
        //                                 ]);

            }
    }





    public function getAllProduct()
    {
                $product=Product::with('subcategory.category',
                'image',
                'user',
                'ratings.user',
                'reviews.user',
                )->where('user_id',Auth::id())->get();
                return response()->json($product);
    }





    public function searshProduct($name)
    {
                $product = Product::with('subcategory.category',
                'image',
                'user',
                'ratings.user',
                'reviews.user',
            )
            ->where('product_name',$name)->get();
            $productId=$product->id;
            $rate=new RatingController();
            $rate_product=$rate-> getRate($productId);
            $views= $product->views;
            $product->update([
            'views' => $views + 1,
                        ]);
            return response()->json([$product, $rate_product]);
    }




    public function product_Id_searsh($productId)
    {
            $product = Product::with('subcategory.category',
                    'image',
                    'user',
                    'ratings.user',
                    'reviews.user',
            )
            ->where('id',$productId)->firstOrFail();
            $rate=new RatingController();
            $rate_product=$rate-> getRate($productId);
            $views= $product->views;
            $product->update([
                'views' => $views + 1,
                            ]);
            return response()->json([$product, $rate_product]);
                    //with('product.image')->
    }





    public function UpdateProduct(Request $request,$productId)
    {
            $validator = Validator::make($request->all(), [
                    'product_name' => 'required|string|between:2,100',
                    'price_product'=>'required|numeric',
                    'description'=>'required|string',
                    'count'=>'required|integer',
                                                        ]);
        if ($validator->fails())
        {
            return response()->json($validator->errors()->toJson(), 400);
        }


        $data= Product::find($productId)->update([
                    'product_name' => $request->product_name,
                    'price_product'=>$request->price_product,
                    'description'=>$request->description,
                    'count'=>$request->count,
                                                ]);




        $images=$request->list_images;
        $input=[];
        $i1=0;$i2=0;
        foreach ($images as $image2)
        {
            $image1=$image2['image'];
            $image_name=time().$image1->getClientOriginalName();
            $image1->move(public_path('upload'),$image_name);
            $path="upload/$image_name";
            $input[$i1]=$path;
            $data= Product::find($productId)->Image()->update([
            'image'=>$input[$i1],
            'Product_id'=>$productId,
                                                            ]);
             $i1++;

        }
            return response()->json(['message'=> 'done']);

    }



        public function deleteProduct($productId)
        {
               // $data =Product::find($productId)->Image()->delete();
                $data =Product::find($productId)->delete();
                return response()->json(['message' => 'true']);

        }




    public function getImage($productId)
    {
        $image=Product::find($productId)->with('image')->get();
        return response()->json($image);
    }

}
