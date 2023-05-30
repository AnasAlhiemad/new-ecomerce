<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Product;
use App\Models\Image;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendCodePasswordConfirmation;
use App\Models\ResetCodePassword;
use Validator;

class AuthController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'ForgotPassword','register']]);
    }

     public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $token = auth()->attempt($validator->validated());
        if (!$token) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        // return $this->createNewToken($token);
        return response()->json([
            "user" => auth()->user(),
            "_token" => $token,
        ]);
    }

    public function register(Request $request) {
        $validator = Validator::make($request->all(),
        [
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
        Mail::to($request->email)->send(new SendCodePasswordConfirmation($codeData->code));

        return response()->json([
            'message' => 'User successfully registered',
            'user' => $user
        ], 201);
    }


    public function logout() {
        auth()->logout();
        return response()->json(['message' => 'User successfully signed out']);
    }

    public function refresh() {
        return $this->createNewToken(auth()->refresh());
    }

    public function userProfile() {
        $user=User::where('id',Auth::id())->with('product')->with('product.image')->get();
        return response()->json($user);
        //return response()->json(auth()->user()->with('user.product.image')->get());
    }

    protected function createNewToken($token){
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->get() * 60,
            'user' => auth()->user()
        ]);
    }


}
