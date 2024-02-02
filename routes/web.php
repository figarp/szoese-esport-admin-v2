<?php

use App\Http\Controllers\AdminController;
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




Route::middleware(['auth', 'verified', 'check.role:vezetoseg'])->group(function () {
    Route::get('/dashboard/admin', [UserController::class, 'index'])->name('dashboard.admin');
    Route::get('/dashboard/admin/usermanagement/edit/{id}', [UserController::class, 'edit'])->name('dashboard.admin.userManagement.edit');
    Route::put('/dashboard/admin/usermanagement/edit/{id}', [UserController::class, 'update'])->name('dashboard.admin.userManagement.update');
});


// ----- Auth -----

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';