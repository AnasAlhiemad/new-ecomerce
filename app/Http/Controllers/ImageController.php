<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function add_image(Request $request)
    {



        // if($request->hasFile('images'))
        // {
        //     $images=$request->file('images');
        //     //return $images;
        //     foreach ($images as $image) {
        //         return "يارب";
        //         $new_image=time().'.'.$image->getClientOriginalExtension();
        //         $image->storeAs('public/images',$new_image);

        //     }
        // }
        $images=$request->list_images;
        $input=[];
        $i1=0;$i2=0;
        foreach ($images as $image2) {
            $image1=$image2['image'];
            $image_name=time().$image1->getClientOriginalName();
            $image1->move(public_path('upload'),$image_name);
            $path="public/upload/$image_name";
            $input[$i1]=$path;

            $image=Image::Create([
                'image'=>$input[$i1],
            ]);
            $i1++;

        }

        return $input;
         //$photo = $request->images;
        // $newphoto = time() . '.' . $request->image->getClientOriginalExtension();
        // $request->image->move(public_path('uploads/photo'), $newphoto);

       }


    /**
     * Display the specified resource.
     */
    public function show(Image $image)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Image $image)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Image $image)
    {
        //
    }
}
