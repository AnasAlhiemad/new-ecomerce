<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Models\Category;
use App\Models\Image;
use App\Models\Product;
use App\Models\Rating;
use App\Models\Review;
use App\Models\User;
use App\Models\SubCategory;
use Illuminate\Support\Facades\Schema;
use Illuminate\Http\Request;
use Validator;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    public function AllCat_WithSub_WithProd()
    {
        $Category =
        Category::with('subcategory.products.user',
        'subcategory.products.image',
        'subcategory.products.reviews',
        'subcategory.products.ratings',
        ) ->get();
        return response()->json($Category);
     }
    public function  getCategories()
    {
        $Category = Category::with('subcategory.products.image',
        'subcategory.products.reviews',
        'subcategory.products.ratings',
        'subcategory.products.user')->get();
        return response()->json($Category);
     }
    public function searsh_Category($name)
    {
        $Category = Category::with(
        'subcategory.products.user',
        'subcategory.products.image',
        'subcategory.products.reviews',
        'subcategory.products.ratings',
        )
        ->where('category_name', $name)->get();
        return response()->json($Category);

      }
    public function category_Id($CatgoryId)
    {
        $Category =
        Category::with(
        'subcategory.products.user',
        'subcategory.products.image',
        'subcategory.products.reviews',
        'subcategory.products.ratings',
        )
        ->where('id',$CatgoryId)->get();
        return response()->json($Category);
     }
    public function updateCategory(Request $request, $CatgoryId)
    {
        $validator = Validator::make($request->all(),
         [
          'category_name' => 'required|string',
          ]);
        if ($validator->fails())
        {
         return response()->json($validator->errors()->toJson(), 400);
         }

        $data= Category::find($CatgoryId)->update([
            'category_name' => $request->category_name,
        ]);

        return response()->json($data);
     }
    public function search($name)
     {
     $Category =Category::with(
      'subcategory.products.user',
      'subcategory.products.image',
      'subcategory.products.reviews',
      'subcategory.products.ratings',)
      ->where('category_name',$name)->get();
     $Sub_Category=SubCategory::with(
      'products.user',
      'products.image',
      'products.reviews',
      'products.ratings',
      'products.user')
       ->where('sub_category',$name)->get();
     $product=Product::with('image','ratings.user','reviews.user')
        ->where('product_name',$name)->get();
     $user=User::with('product.image','product.ratings','product.reviews')
        ->where('name',$name)->get();
     if(!($Category->isEmpty()))
      {
        return $Category;
      }
     if(!($Sub_Category->isEmpty()))
      {
        return $Sub_Category;
      }
     if(!($product->isEmpty()))
      {
        return $product;
      }
     if(!($user->isEmpty()))
      {
        return $user;
      }
     }
 public function deleteCategory($CatgoryId)
{
    $data = Category::find($CatgoryId)->delete();
    return response()->json($data);
}
}

// $x=[1,2,4];
// foreach ($x as $x1) {
//     $y[]= $x1;
// }
// return $y;

// $tables=Schema::getDoctrinesSchemaManager()->listTableNames();
// return $tables;
// if(Category::where('category_name',$name)){
//     return "anas";
// }

// $results= DB::table('categories')
//     ->join('sub_categories','category_id','=','sub_categories.'.'category_id')
//     ->where('categories.'.'category_name',$name)
//     ->orWhere('sub_categories.'.'sub_category',$name)->get();
//     return $results;
// $tables=['sub_categories','categories','products','users'];
// foreach ($tables as $table) {

//    if ($table=="categories")
//     {
//         $category= Category::where('category_name',$name)->firstOrFail();
//        $categoryName=$category->category_name;
//         $Category =
//         Category::with('subcategory.products.user',
//         'subcategory.products.image',
//         'subcategory.products.reviews',
//         'subcategory.products.ratings',
//         )
//         ->where('category_name',$name)->get();
//         return $Category;
//    }
//    if ($table=="sub_categories")
//     {
//         $subCategory= SubCategory::where('sub_category',$name)->firstOrFail();
//         $sub_category=$subCategory->sub_category;
//        $Sub_Category=SubCategory::with('products.user',
//        'products.image',
//        'products.reviews',
//        'products.ratings',
//        'products.user')
//        ->where('sub_category',$name)->get();
//        return response()->json($Sub_Category);
//    }
//    if ($table=="products")
//     {
//         $product=Product::with('image','ratings.user','reviews.user')->where('product_name',$name)->get();
//         return response()->json($product);
//    }
// }

//     $category= Category::where('category_name',$name)->firstOrFail();
//     return "true";
// if ($category->isEmpty()){return "anas";}
// else {
//     return "true";
// }
//    {
//         $category= Category::where('category_name',$name)->firstOrFail();
//         $categoryName=$category->category_name;
//         $Category =
//         Category::with('subcategory.products.user',
//         'subcategory.products.image',
//         'subcategory.products.reviews',
//         'subcategory.products.ratings',
//         )
//         ->where('category_name',$categoryName)->get();
//         return $Category;}

// $Sub_Category=SubCategory::Find($name);
// if ($Sub_Category){
//     return "anas";
//     $product=Product::Find($name);
//     if(!$product){
//     $user=User::Find($name);
//     return $user;
//     }}
//     $categoryName=$category->category_name;
//     $Category =
//     Category::with('subcategory.products.user',
//     'subcategory.products.image',
//     'subcategory.products.reviews',
//     'subcategory.products.ratings',
//     )
//     ->where('category_name',$categoryName)->get();
//     return $Category;
//    }}
//    $Sub_Category=SubCategory::where('sub_category',$name)->firstOrFail();
//    return  $Sub_Category;

// }

// public function deleteCategory($CatgoryId)
// {
//     $data = Category::find($CatgoryId)->delete();
//     return response()->json($data);
// }
//}}
