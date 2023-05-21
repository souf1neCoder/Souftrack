<?php

use Carbon\Carbon;
use App\Models\Account;
use App\Models\Operation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use PHPUnit\Framework\Constraint\Operator;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\SearchController;
use App\Http\Controllers\API\AccountController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\DashboardController;
use App\Http\Controllers\API\OperationController;
use App\Http\Controllers\API\StatisticsController;

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
Route::post('logout',[AuthController::class,'logout']);

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {

    return $request->user();
});
//
Route::controller(AuthController::class)->group(function(){
    Route::post('login','login');
    Route::post('register','register');
});
//

Route::middleware(['auth:sanctum'])->group(function(){
    Route::resource('operations', OperationController::class);
    Route::resource('categories', CategoryController::class);
    Route::patch('/users/{user}',[UserController::class,'changePassword']);
    Route::get('/dashboard',[DashboardController::class,'startUp']);
    Route::patch('/accounts/{account}',[AccountController::class,'update']);
    Route::post('/operations/search/',SearchController::class);
    Route::get('/me',[AuthController::class,'me']);
    Route::get('/statistics',[StatisticsController::class,'index']);
});

