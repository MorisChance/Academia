<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CommodityController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CommentController;
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
//同じルーティングがある場合が下が優先される
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/', [CommodityController::class, 'index'])
    ->middleware('auth')
    ->name('root');
    
Route::get('/welcome', function () {
    return view('welcome');
})->middleware('guest')
    ->name('welcome');
// 下記のdashboardで完結、middleware,authのファイル内に認証されたもの以外は、rejectされwelocomeページに戻るようになっている。
// Route::middleware([
//     'auth:sanctum',
//     config('jetstream.auth_session'),
//     'verified'

// ])->group(function () {
//     Route::get('/dashboard', function () {
//         return view('dashboard');
//     })->name('dashboard');
// });
Route::resource('commodities', CommodityController::class)
    ->middleware('auth');

Route::resource('commodities.purchases', PurchaseController::class)
    ->only(['store', 'destroy', 'show']);

Route::get('/dashboard', [UserController::class, 'dashboard'])
    ->name('dashboard')->middleware('auth');

Route::resource('commodities.comments', CommentController::class)
    ->only(['create', 'store', 'edit','update', 'destory'])
    ->middleware('auth');
