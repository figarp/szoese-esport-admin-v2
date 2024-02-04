<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\DashboardController;
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


// ----- Vezetosegi Útvonalak -----
Route::middleware(['auth', 'verified', 'checkRole:vendeg,tag,csoportvezeto,vezetoseg'])->group(function () {
    // Csoport létrehozása
    Route::get('/dashboard/groups/create', [GroupController::class, 'create'])->name('dashboard.groups.create');
    Route::post('/dashboard/groups', [GroupController::class, 'store'])->name('dashboard.groups.store');

    // Csoport törlése
    Route::delete('/dashboard/groups/{id}', [GroupController::class, 'destroy'])->name('dashboard.groups.destroy');
});

// ----- Csoportvezeto Útvonalak -----
Route::middleware(['auth', 'verified', 'checkRole:vendeg,tag,csoportvezeto'])->group(function () {
    // Csoport szerkesztése
    Route::get('/dashboard/groups/{id}/edit', [GroupController::class, 'edit'])->name('dashboard.groups.edit');
    Route::put('/dashboard/groups/{id}', [GroupController::class, 'update'])->name('dashboard.groups.update');
});

// ----- Tag Útvonalak -----
Route::middleware(['auth', 'verified', 'checkRole:vendeg,tag'])->group(function () {

});

// ----- Vendég Útvonalak -----
Route::middleware(['auth', 'verified', 'checkRole:vendeg'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'home'])->name('dashboard');  // Dashboard Főoldal
    Route::get('/dashboard/users', [UserController::class, 'index'])->name('dashboard.users');  // Dashboard Főoldal

    Route::get('/dashboard/groups', [GroupController::class, 'index'])->name('dashboard.groups.index'); // Csoportok oldal
    Route::get('/dashboard/groups/{id}', [GroupController::class, 'show'])->name('dashboard.groups.show'); // Csoport megtekintése
});

// ----- Működésért felelős útvonalak -----
Route::middleware(['auth', 'verified'])->group(function () {
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