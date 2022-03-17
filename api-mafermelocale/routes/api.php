<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\CategoryController;

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

Route::post('login', [AuthController::class, 'signin']);
Route::post('register', [AuthController::class, 'signup']);

Route::post('loginadmin', [AuthController::class, 'signinAdmin']);
Route::post('registeradmin', [AuthController::class, 'signupAdmin']);

//Route::get('users', [UserController::class, 'index']);

/**
 * Only authenticated users can call the route named here
 */
Route::middleware(['auth:sanctum_user'])->group(function () {

    /**
     * Here is listed all the route with the UserController class
     * 
     */
    Route::controller(UserController::class)->group(function () {

        Route::get('users', 'index');

        Route::put('users/{id}', 'update');

        Route::delete('users/{id}', 'destroy');

    });
});

Route::middleware(['auth:sanctum_admin'])->group(function () {

    /**
     * Here is listed all the route with the UserController class
     * 
     */
    Route::controller(UserController::class)->group(function () {

        Route::get('users/{id}', 'show');

    });

    Route::controller(CategoryController::class)->group(function () {

        Route::get('categories', 'index');

        Route::post('categories', 'store');

    });
});