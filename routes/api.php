<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\LoginController;
use App\Http\Controllers\api\UserPostController;

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
Route::post('login', [LoginController::class, 'login'])->name('api.login');
// Route::post('logout', [LoginController::class, 'logout'])->middleware('auth:api');

//POST LISTING API
Route::post('post-listing', [UserPostController::class, 'postListing'])->name('api.post-listing');

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
