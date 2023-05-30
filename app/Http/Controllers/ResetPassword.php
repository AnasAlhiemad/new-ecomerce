<?php

namespace App\Http\Controllers;

use App\Models\sub_Category;
use Illuminate\Http\Request;
use Validator;
class SubCategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function get_all_SubCategory(){
        $Sub_Category=sub_Category::all();
        return response()->json($Sub_Category);
    }
    public function Sub_Category_Product(){
        $Sub_Category=sub_Category::with('products')->get();
         return response()->json($Sub_Category);
    }
    public function Find_IdSubCategory($id){
        $Sub_Category=sub_Category::with('products')
        ->where('id',$id)->get();
        return response()->json($Sub_Category);
    }
    public function Find_NameSubCategory($name){
        $Sub_Category=sub_Category::with('products')
        ->where('sub_category',$name)->get();
        return response()->json($Sub_Category);
    }
}
