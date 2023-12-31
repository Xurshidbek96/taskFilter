<?php

use App\Http\Controllers\Api\FilterController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ProductController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResources([
    'products' => ProductController::class,
    'orders' => OrderController::class,
]) ;

Route::get('statistics/month', [FilterController::class, 'statistic_month']);
Route::get('chart/month', [FilterController::class, 'chartByMonth']);
Route::get('chart/twoMonths', [FilterController::class, 'chartByTwoMonths']);
