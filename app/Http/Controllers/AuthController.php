<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Product;
use App\Models\Image;
use App\Models\Cart;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use App\Mail\SendCodePasswordConfirmation;
use App\Models\ResetCodePassword;
use Validator;

class AuthController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login','register']]);
      }

    public function login(Request $request)
    {
       $validator = Validator::make($request->all(), [
        'email' => 'required|email',
        'password' => 'required|string|min:6',
          ]);
     if ($validator->fails())
       {
        return response()->json($validator->errors(), 422);
         }
      $token = auth()->attempt($validator->validated());
     if (!$token)
        {
           return response()->json(['error' => 'Unauthorized'], 401);
         }
         $cart=Cart::create([
            'my_cart'=>'my_cart',
            'user_id'=>Auth::id(),
            'sub_total'=>0,
        ]);
        return response()->json([
          "user" => auth()->user(),
          "_token" => $token,
          ]);
    }

    public function register(Request $request)
    {
     $validator = Validator::make($request->all(), [
     'name' => 'required|string|between:2,100',
     'email' => 'required|string|email|max:100|unique:users',
     'number' => 'required|string|min:10',
     'password' => 'required|string|min:6',
        ]);
    if($validator->fails())
     {
        return response()->json($validator->errors()->toJson(), 400);
        }
     $user = User::create(array_merge(
     $validator->validated(),
     ['password' => bcrypt($request->password)]
                                        ));

     $code = mt_rand(100000, 999999);
     $email['email']=$request->email;
     $codeData = ResetCodePassword::create([
      'code'=>$code,
      'email'=>$request->email]);
        // Send email to user
      Mail::to($request->email)
       ->send(new SendCodePasswordConfirmation($codeData->code));
     return response()->json([
        'message' => 'User successfully registered',
        'user' => $user
        ], 201);
    }

    public function logout()
     {
      auth()->logout();
      return response()->json(['message' => 'User successfully signed out']);
       }



       public function UpdateProfile(Request $request,$userId)
       {
               $validator = Validator::make($request->all(), [
                'name' => 'required|string|between:2,100',
                'number' => 'required|string|min:10',
                                                           ]);
           if ($validator->fails())
           {
               return response()->json($validator->errors()->toJson(), 400);
           }


           $user= User::find($userId)->update([
            'name' => $request->name,
            'number' => $request->number,
                                                   ]);

         return response()->json(['message'=> 'done']);
       }
    public function refresh()
     {
        return $this->createNewToken(auth()->refresh());
       }

    public function userProfile()
     {
        $user=User::where('id',Auth::id())//->get();
        ->with('product.subcategory.category','product.image','product.ratings.user','product.reviews.user')->get();
        return response()->json($user);
      //   $user1=DB::table('users')
      //   ->join('products','products.user_id','=','users.id')
      //   ->join('sub_categories','sub_categories.id','=','products.subcategory_id')
      //   ->select(
      //   'products.product_name','products.price_product',
      //   'products.views','products.description','products.count','sub_categories.sub_category')
      //   ->where('users.id','=',Auth::id())->get();
      //   return response()->json([$user,$user1]);
        //return response()->json(auth()->user()->with('user.product.image')->get());
         //'users.id','users.name','users.email','users.number'
      }
    public function userAccunt($id)
     {
        $user=User::where('id',$id)
        ->with('product.image','product.ratings','product.reviews')->get();
        return response()->json($user);
        //return response()->json(auth()->user()->with('user.product.image')->get());
      }

    protected function createNewToken($token)
     {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->get() * 60,
            'user' => auth()->user()
        ]);
        }


}
