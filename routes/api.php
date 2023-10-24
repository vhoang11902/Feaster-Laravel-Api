<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AttributeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CheckOutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
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

//FRONT-END
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/allCategory', [CategoryController::class, 'indexFE']);
Route::get('/category/{id}', [CategoryController::class, 'show']);
Route::get('/showSearch', [CategoryController::class, 'showSearch']);
Route::get('/product/{id}', [ProductController::class, 'show']);
Route::get('/allAttribute', [AttributeController::class, 'index']);
Route::post('/addCart', [CartController::class, 'create']);
Route::get('/cartItem', [CartController::class, 'index']);
Route::post('orderPlace', [CheckoutController::class, 'store']);

//BACK-END
Route::group(['middleware' => ['jwt.auth']], function () {
//    user
    Route::get('user', [AuthController::class, 'user']);
    Route::post('logout', [AuthController::class, 'logout']);

//    category
    Route::get('/category', [CategoryController::class, 'index']);
    Route::get('/edit-category/{id}', [CategoryController::class, 'show']);
    Route::put('/update-category/{id}', [CategoryController::class, 'update']);
    Route::post('/save-category', [CategoryController::class, 'create']);
    Route::post('/active-category/{id}', [CategoryController::class, 'activeCategory']);
    Route::delete('/delete-category/{id}', [CategoryController::class, 'destroy']);
    Route::post('/unactive-category/{id}', [CategoryController::class, 'unactiveCategory']);

//      product
    Route::get('/product', [ProductController::class, 'index']);
    Route::get('/edit-product/{id}', [ProductController::class, 'edit']);
    Route::post('/update-product/{id}', [ProductController::class, 'update']);
    Route::post('/save-product', [ProductController::class, 'create']);
    Route::post('/active-product/{id}', [ProductController::class, 'active_product']);
    Route::delete('/delete-product/{id}', [ProductController::class, 'destroy']);
    Route::post('/unactive-product/{id}', [ProductController::class, 'unactive_product']);

    //attribute
    Route::get('/attribute', [AttributeController::class, 'index']);
    Route::get('/attribute-pro', [AttributeController::class, 'showAttrValue']);
    Route::get('/variant-pro', [AttributeController::class, 'showVariantPros']);
    Route::post('/save-attrValue/{id}', [AttributeController::class, 'create']);
    Route::post('/save-variant/{id}', [AttributeController::class, 'createVariant']);
    Route::delete('/delete-attrValue/{id}', [AttributeController::class, 'destroy']);
    Route::delete('/delete-variant/{id}', [AttributeController::class, 'destroySKU']);


//    order
    Route::get('/allOrder', [OrderController::class, 'index']);
    Route::get('/orderDetail/{id}', [OrderController::class, 'show']);
    Route::delete('/deleteOrder/{id}', [OrderController::class, 'destroy']);
});

