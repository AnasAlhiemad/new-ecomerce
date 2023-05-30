<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Image;
use App\Models\Product;
use App\Models\User;
use App\Models\sub_Category;
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
        //$Category =
        $Category = Category::with('subcategory.products.image','subcategory.products.user')
        ->get();
        return response()->json($Category);
    }
    public function  getCategories()
    {
        $Category = Category::all();
        return response()->json($Category);
    }
    public function searsh_Category($name)
    {
        $Category = Category::with('subcategory.products.image','subcategory.products.user')
        ->where('category_name', $name)->get();
        return response()->json($Category);

    }
    public function category_Id($CatgoryId)
    {
        $Category =
        Category::with('subcategory.category','subcategory.products')
        ->where('id',$CatgoryId)->get();
        return response()->json($Category);
    }
    public function updateCategory(Request $request, $CatgoryId)
    {
        $validator = Validator::make($request->all(), [

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


    // public function deleteCategory($CatgoryId)
    // {
    //     $data = Category::find($CatgoryId)->delete();
    //     return response()->json($data);
    // }
}
