<?php

namespace App\Models;
use App\Models\sub_Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $table = "categories";
    protected $fillable = [
        'category_name',
    ];
  //  protected $primaryKey = "id";
    public $timestamps = true;

    // public function products() {
    //     return $this->hasMany(Product::class);
    // }

    public function subcategory()
    {
        return $this->hasMany(sub_Category::class,'category_id');
    }
}
