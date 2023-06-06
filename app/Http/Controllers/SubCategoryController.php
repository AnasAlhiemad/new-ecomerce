<?php

namespace App\Http\Controllers;

use App\Models\SubCategory;
use Illuminate\Http\Request;
use Validator;
class SubCategoryController extends Controller
{
    public function __construct()
     {
        $this->middleware('auth:api');
     }

    public function get_all_SubCategory()
     {
        $Sub_Category=SubCategory::with('products.user',
        'products.image',
        'products.reviews',
        'products.ratings',
        'products.user')->get();
        return response()->json($Sub_Category);
       }
    public function Sub_Category_Product()
     {
        $Sub_Category=SubCategory::with('products.user',
        'products.image',
        'products.reviews',
        'products.ratings',
        'products.user')->get();
         return response()->json($Sub_Category);
       }
    public function Find_IdSubCategory($id)
     {
        $Sub_Category=SubCategory::with('products.user',
        'products.image',
        'products.reviews',
        'products.ratings',
        'products.user')
        ->where('id',$id)->get();
        return response()->json($Sub_Category);
      }
    public function Find_NameSubCategory($name)
     {
        $Sub_Category=SubCategory::with('products.user',
        'products.image',
        'products.reviews',
        'products.ratings',
        'products.user')
        ->where('sub_category',$name)->get();
        return response()->json($Sub_Category);
       }
}
