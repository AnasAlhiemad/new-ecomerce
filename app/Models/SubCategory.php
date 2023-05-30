<?php

namespace App\Models;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class sub_Category extends Model
{
    use HasFactory;
    protected $table = "sub_categories";
    protected $fillable = [
        'sub_category',
        'category_id',
    ];
    //  protected $primaryKey = "id";
    //  public $timestamps = true;

    public function products() {
        return $this->hasMany(Product::class,'subcategory_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
