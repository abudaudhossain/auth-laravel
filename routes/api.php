<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;
use App\Http\Controllers\VisitorController;

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
Route::middleware(['auth:api', 'user-access:admin'])->get('/admin/user', function (Request $request) {
    return "This is admin router";
});
Route::middleware(['auth:api', 'user-access:manager'])->get('/manager/user', function (Request $request) {
    return "This is manager router";
});

route::get('/', function(){
    return "Welcome to Auth by laravel";
});

route::post("/reg/user", [UserController::class, 'regUser']);

route::post('/create/visitor', [VisitorController::class, 'addNewVisitor']);

Route::middleware(['auth:visitor-api', ])->get('/visitor', function (Request $request) {
    return $request->user();
});
