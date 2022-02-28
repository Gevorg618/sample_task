<?php

use App\Http\Controllers\CardController;
use App\Http\Controllers\ColumnController;
use App\Http\Controllers\ExportController;
//use App\Http\Controllers\ItemController;
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

//Route::resource('items', ItemController::class);
Route::resource('columns', ColumnController::class);
Route::resource('cards', CardController::class);
Route::post('/export', [ExportController::class, 'export']);
Route::get('/list-cards', [CardController::class, 'listCards']);
