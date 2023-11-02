<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/



Route::get('/test', function(){
    $data = [
        'cha1',
        'chapat',
        'mazowa',
        'milk',
    ];
      return  response()->json($data);
});


// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// public routes
Route::post('/register', [AuthController::class,'register']);
Route::post('/login', [AuthController::class,'login']);
Route::get("/product-search/{name}", [ProductsController::class,"search"]);

// protected routes

Route::group(['middleware'=> 'auth:sanctum'], function () { 
    Route::resource("/products", ProductsController::class);
    Route::post('/logout', [AuthController::class,'logout']);
});