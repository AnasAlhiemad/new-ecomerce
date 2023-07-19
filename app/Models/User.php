<?php
namespace App\Models;
use App\Models\Product;
use App\Models\Image;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Rating;
use App\Models\Category;
use App\Models\CartOrder;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'number',
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier() {
        return $this->getKey();
    }

    public function getJWTCustomClaims() {
        return [];
    }
    public function product()
    {
        return $this->hasMany(Product::class,'user_id');
    }
    public function favorit()
    {
        return $this->hasMany(Favorite::class,'user_id');
    }
    public function cart()
    {
        return $this->hasOne(Cart::class,'user_id');
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class,'user_id');
    }
    public function reviews()
    {
        return $this->hasMany(Review::class,'user_id');
    }
    public function order()
    {
        return $this->hasMany(Order::class,'recip_id');
    }
}
