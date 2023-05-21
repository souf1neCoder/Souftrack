<?php

use Carbon\Carbon;
use App\Models\User;
use App\Models\Account;
use App\Models\Operation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/{any}', function () {
    return view('welcome');
    // $account =auth('sanctum')->user();
    // set date settings
    // $start_of_month = Auth::user();
    // $now = Carbon::now();
    // $nowNextMonth = Carbon::now()->addMonth();
    // $start_date = Carbon::createFromFormat('d/m/Y', "$start_of_month/$now->month/$now->year");
    // $end_date = Carbon::createFromFormat('d/m/Y',"$start_of_month/$nowNextMonth->month/$nowNextMonth->year");
    // $expensesLastMonth = Operation::whereRelation('categories','category_type','expense')->where('account_id',32)->whereDate('created_at', '>=', $start_date)->whereDate('created_at', '<=', $end_date)->sum('amount');
    // return compact('start_of_month');
})->where('any','.*');

