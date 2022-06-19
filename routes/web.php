<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::post('/bot', [\App\Http\Controllers\MainController::class, 'contact'])->name('contact');
Route::post('/webhook', [\App\Http\Controllers\WebhookController::class, 'contact'])->name('webhook');
