<?php
use App\Http\Controllers\API\CommodityController;
use App\Http\Controllers\API\CommentController;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('commodities', CommodityController::class)
    ->middleware('auth:api');

Route::apiResource('commodities.comments', CommentController::class)
    ->middleware('auth:api')
    ->only(['store', 'show', 'update', 'destroy'])
    ->names('api.commodities.comments');
