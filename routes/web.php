<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AppController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RequestController;
use App\Http\Controllers\DashboardController;


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

Route::get('/app/login/discord', [AuthController::class, 'login']);
Route::get('/app/login', [AuthController::class, 'redirect']);
Route::get('/app/logout', [AuthController::class, 'logout']);

Route::post('/app/publickey', [AppController::class, 'verifyPublicKey']);

Route::post('/app/requests/create', [RequestController::class, 'create']);
Route::get('/app/requests/fetch', [RequestController::class, 'fetch']);
Route::get('/app/requests/list', [RequestController::class, 'list']);

Route::get('/{any}', [DashboardController::class, 'index'])->where('any', '.*');
