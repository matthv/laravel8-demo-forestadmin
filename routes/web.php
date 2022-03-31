<?php

use App\Http\Controllers\ChartsController;
use App\Http\Controllers\ComicsController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SmartActionBooksController;
use App\Http\Controllers\SmartActionProductsController;
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

Route::get('/', [HomeController::class, 'index']);

// Smart relationships
//Route::get('forest/book/{book}/relationships/smartBookstores', [BooksController::class, 'bookstores']);

Route::get('forest/comic', [ComicsController::class, 'index']);

// Charts
Route::post('forest/charts/example-value', [ChartsController::class, 'value']);
Route::post('forest/charts/example-pie', [ChartsController::class, 'pie']);
Route::post('forest/charts/example-line', [ChartsController::class, 'line']);
Route::post('forest/charts/example-objective', [ChartsController::class, 'objective']);
Route::post('forest/charts/example-leaderboard', [ChartsController::class, 'leaderboard']);

Route::get('forest/comic', [ComicsController::class, 'index']);
Route::post('forest/comic', [ComicsController::class, 'store']);
Route::get('forest/comic/{id}', [ComicsController::class, 'show']);
Route::put('forest/comic/{id}', [ComicsController::class, 'update']);
Route::delete('forest/comic/{id}', [ComicsController::class, 'destroy']);
