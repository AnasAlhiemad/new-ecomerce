<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SubCategoryController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\CartOrderController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ResetPassword;
use App\Http\Controllers\CodeCheck;
use App\Http\Controllers\ForgotPassword;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\ReviewController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

    Route::post('/login', [AuthController::class, 'login']);
    Route::post('password/email',[ForgotPassword::class,'forgotPassword']);
    Route::post('/password/code/check',[CodeCheck::class,'codeCheck']);
    Route::post('/password/reset',[ResetPassword::class,'resetPassword']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/user-profile', [AuthController::class, 'userProfile']);

              ##############PRODUCT#######################
    Route::post('/addproduct',[ProductController::class,'add_product']);
    Route::get('/getAllProduct',[ProductController::class,'getAllProduct']);
    Route::get('/searshProduct/{name}',[ProductController::class,'searshProduct']);
    Route::post('/product_Id_searsh/{productId}',[ProductController::class,'product_Id_searsh']);
    Route::post('/UpdateProduct/{productId}',[ProductController::class,'UpdateProduct']);
    Route::post('/deleteProduct/{productId}',[ProductController::class,'deleteProduct']);
    Route::get('/getImage/{productId}',[ProductController::class,'getImage']);

         //Route::post('/addimage',[ImageController::class,'add_image']);
                   ####################category###############
    Route::get('/allCat_withSub_withProd',[CategoryController::class,'AllCat_WithSub_WithProd']);
    Route::get('/getCategories',[CategoryController::class,'getCategories']);
    Route::get('/searsh_Category/{name}',[CategoryController::class,'searsh_Category']);
    Route::get('/category_Id/{CatgoryId}',[CategoryController::class,'category_Id']);
    Route::post('/updateCategory/{CatgoryId}',[CategoryController::class,'updateCategory']);
    Route::post('/deleteCategory/{CatgoryId}',[CategoryController::class,'deleteCategory']);
                   ################################## Sub_Category #############
    Route::get('/get_all_SubCategory',[SubCategoryController::class,'get_all_SubCategory']);
    Route::get('/Sub_Category_Product',[SubCategoryController::class,'Sub_Category_Product']);
    Route::get('/Find_IdSubCategory/{id}',[SubCategoryController::class,'Find_IdSubCategory']);
    Route::get('/Find_NameSubCategory/{name}',[SubCategoryController::class,'Find_NameSubCategory']);
               #################### favorit  ####################

    Route::post('/addFavorite/{id}',[FavoriteController::class,'addFavorite']);
    Route::post('/delete_favorite/{IdFavorite}',[FavoriteController::class,'delete_favorite']);
    Route::get('/get_myFavorite',[FavoriteController::class,'get_myFavorite']);

                #####################CART#################
    Route::post('/CreateCart',[CartController::class,'CreateCart']);
    Route::get('/getCart',[CartController::class,'getCart']);
    Route::post('/addOrder/{product_id}',[CartOrderController::class,'addOrder']);

                ###################  Rating    ###############
    Route::post('/addrating/{id}',[RatingController::class,'addrating']);
    Route::get('/getRate/{id}',[RatingController::class,'getRate']);
    Route::post('/update/{id}',[RatingController::class,'update']);
    Route::get('/myratings',[RatingController::class,'myratings']);
    Route::post('/delete/{id}',[RatingController::class,'delete']);

            ###################  Rating    ###############
    Route::post('/addreview/{id}',[ReviewController::class,'addreview']);
    Route::post('/update/{id}',[ReviewController::class,'update']);
    Route::post('/delete/{id}',[ReviewController::class,'delete']);
    Route::get('/getReview/{id}',[ReviewController::class,'getReview']);
