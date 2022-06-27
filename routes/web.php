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
Route::get('/', [\App\Http\Controllers\MainController::class, 'index'])->name('index');
Route::get('/contacto', [\App\Http\Controllers\MainController::class, 'contact'])->name('contact');
Route::get('/como-participar', [\App\Http\Controllers\MainController::class, 'howToParticipe'])->name('how_to_participe');
Route::get('/ganadores', [\App\Http\Controllers\MainController::class, 'winners'])->name('winners');
Route::get('/premios', [\App\Http\Controllers\MainController::class, 'awards'])->name('awards');
Route::get('/productos-participantes', [\App\Http\Controllers\MainController::class, 'participantProducts'])->name('participant_products');
//Route::post('/bot', [\App\Http\Controllers\MainController::class, 'contact'])->name('contact');
//Route::post('/webhook', [\App\Http\Controllers\WebhookController::class, 'contact'])->name('webhook');
