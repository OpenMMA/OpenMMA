<?php

use App\Http\Controllers\ExternalEmailVerificationController;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\GroupCategoryController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SystemSettingController;

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

Route::get('/', function() {
    return redirect('/events');
});

Route::get('/events', [EventController::class, 'index']);
Route::post('/events', [EventController::class, 'getevents']);
Route::get('/event/{event:slug}', [EventController::class, 'show']);

Route::prefix('user')->group(function() {
    Route::post('{user:id}/verify', [UserController::class, 'verify']);
});

// Route::get('/external/email/verify');
Route::get('/external/email/verify/{id}/{hash}', [ExternalEmailVerificationController::class, '__invoke'])->name('external-verification.verify');

Route::middleware('verified')->group(function() {
    // TODO not sure if this route was used anywhere, probably not. Remove later.
    // Route::get('/users/search', [UserController::class, 'search']);

    Route::prefix('event')->group(function() {
        Route::get('/{event:slug}/edit',           [EventController::class, 'edit'])->middleware(['can.group:.event.edit']);
        Route::put('/{event:slug}/edit/{action}',  [EventController::class, 'update'])->whereIn('action', ['body'])->middleware(['can.group:.event.edit']);;
        Route::post('/{event:slug}/edit/{action}', [EventController::class, 'update'])->whereIn('action', ['banner', 'max_registrations', 'tags'])->middleware(['can.group:.event.edit']);;
        Route::post('/{event:slug}/register', [EventController::class, 'register']);
        Route::post('/{event:slug}/unregister', [EventController::class, 'unregister']);
        Route::delete('/{event:slug}', [EventController::class, 'destroy'])->middleware(['can.group:.event.delete']);;
    });

    Route::prefix('dashboard')->middleware('can:access_dashboard')->group(function() {
        Route::get('/', function() { return view('dashboard.index'); });

        Route::get('/users', [UserController::class, 'index']);
        Route::get('/user/{user:id}', [UserController::class, 'show']);

        Route::get('/groups', [GroupController::class, 'index']);
        Route::post('/groups/create', [GroupController::class, 'store']);

        Route::get('/group/{group:name}', [GroupController::class, 'show']);
        Route::post('/group/{group}/add/role', [RoleController::class, 'store']);
        Route::get('/group/{group}/role/{role}', [RoleController::class, 'show']);

        Route::get('/category/{category:name}', [GroupCategoryController::class, 'show']);

        Route::get('/events', [EventController::class, 'dashboardIndex']);

        Route::get('/system-settings', [SystemSettingController::class, 'index']);
        Route::post('/system-settings', [SystemSettingController::class, 'update']);

        Route::get('/group-settings', [GroupController::class, 'index']);
        Route::post('/group-settings/add/group', [GroupController::class, 'store']);
        Route::post('/group-settings/add/category', [GroupCategoryController::class, 'store']);

        Route::get('/temp', function() { return view('components.form-wysiwyg'); });
    });

    Route::prefix('profile')->group(function() {
        Route::get('/', [UserController::class, 'profile']);
        Route::get('/events', [EventController::class, 'profileIndex']);
    });
});
