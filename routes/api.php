<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('register', [
    UserController::class, 'register'
]);
Route::post('login', [
    UserController::class, 'login'
]);

Route::apiResources([
    'cart'=> CartController::class,
]);

Route::middleware('jwt.auth')->group(function () {
    Route::post('products', [
        ProductController::class, 'store'
    ]);
    Route::delete('products/{product}', [
        ProductController::class, 'destroy'
    ]);
    Route::put('products/{product}', [
        ProductController::class, 'update'
    ]);

    Route::post('category', [
        CategoryController::class, 'store'
    ]);
    Route::delete('category/{category}', [
        CategoryController::class, 'destroy'
    ]);
    Route::put('category/{category}', [
        CategoryController::class, 'update'
    ]);
    Route::get('/products/search/{name}', [
        ProductController::class, 'search'
    ]);
    Route::post('/user/change-password', [
        UserController::class, 'changePassword'
    ]);
});



Route::get('products/{product}', [
    ProductController::class, 'show'
]);
Route::get('products', [
    ProductController::class, 'index'
]);

Route::get('category/{category}', [
    CategoryController::class, 'show'
]);
Route::get('category', [
    CategoryController::class, 'index'
]);



//fetch all the products in a particular category
Route::get('/category/products/{cat_id}', [
    ProductController::class, 'productCategory'
]);

Route::post('orderProduct', [
    ProductController::class, 'orderProduct'
])->middleware('jwt.auth');
Route::get('cart', [
    CartController::class, 'cart'
])->middleware('jwt.auth');

Route::delete('cart/deleteProduct/{cart_id}', [
    CartController::class, 'deleteProduct'
])->middleware('jwt.auth');

Route::put('cart/updateCart/{cart_id}', [
    CartController::class, 'updateCart'
])->middleware('jwt.auth');



Route::get('pay', [
    PaymentController::class, 'redirectToGateway'
]);

Route::get('payment/callback', [
    PaymentController::class, 'handleGatewayCallback'
]);