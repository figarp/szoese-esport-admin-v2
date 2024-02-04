<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
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

// ----- Public -----

Route::get('/', function () {
    return view('welcome');
})->name("home");


// ----- Dashboard -----

Route::get('/dashboard', function () {
    return view('dashboard.index');
})->middleware(['auth', 'verified'])->name('dashboard');



// ----- Vezetőségi Útvonalak -----
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard/admin', [UserController::class, 'index'])->name('dashboard.admin');
    Route::get('/dashboard/admin/usermanagement/edit/{id}', [UserController::class, 'edit'])->name('dashboard.admin.userManagement.edit');
    Route::put('/dashboard/admin/usermanagement/edit/{id}', [UserController::class, 'update'])->name('dashboard.admin.userManagement.update');

    Route::get('/dashboard/groups', [GroupController::class, 'index'])->name('dashboard.groups.index');
    Route::get('/dashboard/groups/create', [GroupController::class, 'create'])->name('dashboard.groups.create');
    Route::post('/dashboard/groups', [GroupController::class, 'store'])->name('dashboard.groups.store');
    Route::get('/dashboard/groups/{id}', [GroupController::class, 'show'])->name('dashboard.groups.show');
    Route::get('/dashboard/groups/{id}/edit', [GroupController::class, 'edit'])->name('dashboard.groups.edit');
    Route::put('/dashboard/groups/{id}', [GroupController::class, 'update'])->name('dashboard.groups.update');
    Route::delete('/dashboard/groups/{id}', [GroupController::class, 'destroy'])->name('dashboard.groups.destroy');


});

// ----- User -----
Route::middleware(['auth'])->group(function () {
    Route::get('/search-leaders', [GroupController::class, 'searchLeaders']);

    Route::post('/groups/{groupId}/join', [UserController::class, 'joinGroup'])->name('groups.join');
    Route::post('/groups/{groupId}/leave', [UserController::class, 'leaveGroup'])->name('groups.leave');
});

// ----- Auth -----
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';