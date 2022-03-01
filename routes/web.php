<?php

use App\Http\Controllers\ChartsController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SmartActionsController;
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

Route::post('forest/smart-actions/smart-action-single', [SmartActionsController::class, 'single']);
Route::post('forest/smart-actions/smart-action-bulk', [SmartActionsController::class, 'bulk']);
Route::post('forest/smart-actions/smart-action-global', [SmartActionsController::class, 'global']);
Route::post('forest/smart-actions/smart-action-download', [SmartActionsController::class, 'download']);
Route::post('forest/smart-actions/smart-action-hook', [SmartActionsController::class, 'hook']);
Route::post('forest/smart-actions/add-comment', [SmartActionsController::class, 'addComment']);
