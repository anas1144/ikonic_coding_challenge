<?php

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

Route::get('/', function () {
    return view('welcome');
});



Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::post('/get_suggestions', [\App\Http\Controllers\SuggestionsController::class, 'index'])->name('get.suggestions');

Route::post('/get_connections', [\App\Http\Controllers\ConnectionsController::class, 'index'])->name('get.connections');
Route::post('/delete_connections', [\App\Http\Controllers\ConnectionsController::class, 'destroy'])->name('delete.connections');

Route::post('/get_connection_in_common', [\App\Http\Controllers\ConnectionsInCommonController::class, 'index'])->name('get.connection.in.common');

Route::post('/get_requests', [\App\Http\Controllers\RequestsController::class, 'index'])->name('get.requests');
Route::post('/add_request', [\App\Http\Controllers\RequestsController::class, 'store'])->name('add.requests');
Route::post('/accept_requests', [\App\Http\Controllers\RequestsController::class, 'update'])->name('accept.requests');
Route::post('/delete_request', [\App\Http\Controllers\RequestsController::class, 'destroy'])->name('delete.requests');
