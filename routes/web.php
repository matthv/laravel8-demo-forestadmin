<?php

use App\Http\Controllers\ChartsController;
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

Route::post('forest/charts/example-value', [ChartsController::class, 'value']);
Route::post('forest/charts/example-pie', [ChartsController::class, 'pie']);
Route::post('forest/charts/example-line', [ChartsController::class, 'line']);
Route::post('forest/charts/example-objective', [ChartsController::class, 'objective']);
Route::post('forest/charts/example-leaderboard', [ChartsController::class, 'leaderboard']);

Route::post('forest/smart-actions/smart-action-single', [SmartActionBooksController::class, 'single']);
Route::post('forest/smart-actions/smart-action-bulk', [SmartActionBooksController::class, 'bulk']);
Route::post('forest/smart-actions/smart-action-global', [SmartActionBooksController::class, 'global']);
Route::post('forest/smart-actions/smart-action-download', [SmartActionBooksController::class, 'download']);
Route::post('forest/smart-actions/add-comment', [SmartActionBooksController::class, 'addComment']);

Route::post('forest/smart-actions/smart-action-hook', [SmartActionProductsController::class, 'hook']);
