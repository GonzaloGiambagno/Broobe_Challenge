<?php

use App\Http\Controllers\HistoryController;
use App\Http\Controllers\MetricController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [MetricController::class, 'index'])->name('run_metric');
Route::post('/get_metric', [MetricController::class, 'getMetrics'])->name('get_metric');
Route::post('/store_metric', [MetricController::class, 'storeMetric'])->name('store_metric');

Route::get('/history', [HistoryController::class, 'showHistory'])->name('history');
