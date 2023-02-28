<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;

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
    return view('index');
});


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('verified');


Route::get('/events', [EventController::class, 'index']);
Route::post('/events', [EventController::class, 'getevents']);
Route::get('/event/create', [EventController::class, 'create']);
Route::post('/event/create', [EventController::class, 'store']);
Route::get('/event/{event:slug}/edit', [EventController::class, 'edit']);
Route::put('/event/{event:slug}/edit', [EventController::class, 'update']);
Route::get('/event/{event:slug}', [EventController::class, 'show']);
Route::delete('/event/{event:slug}', [EventController::class, 'destroy']);