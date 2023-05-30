<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
//use App\Models\User;
use App\Models\Product;
class Rating extends Model
{
    use HasFactory;
    protected $table = "ratings";
    protected $fillable = [
        'user_id',
        'product_id',
        'rate',
        'review',
    ];

   /* public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
*/
    public function product()
    {
        return $this->belongsTo(product::class, 'product_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
