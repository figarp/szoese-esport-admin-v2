<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ApplicationsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Mail\NewApplicationMail;
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
Route::get('/groups', [GroupController::class, 'indexPublic'])->name('groups.index');
Route::get('/groups/{id}', [GroupController::class, 'showPublic'])->name('groups.show');


// ----- Vezetosegi Útvonalak -----
Route::middleware(['auth', 'verified', 'checkRole:vendeg,tag,csoportvezeto,vezetoseg'])->group(function () {
    // Csoport létrehozása
    Route::get('/dashboard/groups/create', [GroupController::class, 'create'])->name('dashboard.groups.create');
    Route::post('/dashboard/groups', [GroupController::class, 'store'])->name('dashboard.groups.store');

    // Csoport törlése
    Route::delete('/dashboard/groups/{id}', [GroupController::class, 'destroy'])->name('dashboard.groups.destroy');

    // Bejegyzés létrehozása
    Route::get('/dashboard/posts/create', [PostsController::class, 'create'])->name('dashboard.posts.create');
    Route::post('/dashboard/posts', [PostsController::class, 'store'])->name('dashboard.posts.store');

    // Bejegyzés módosítása
    Route::get('/dashboard/posts/{id}/edit', [PostsController::class, 'edit'])->name('dashboard.posts.edit');
    Route::put('/dashboard/posts/{id}', [PostsController::class, 'update'])->name('dashboard.posts.update');

    // Bejegyzés törlése
    Route::delete('/dashboard/posts/{id}', [PostsController::class, 'destroy'])->name('dashboard.posts.destroy');
});

// ----- Csoportvezeto Útvonalak -----
Route::middleware(['auth', 'verified', 'checkRole:vendeg,tag,csoportvezeto'])->group(function () {
    // Csoport szerkesztése
    Route::get('/dashboard/groups/{id}/edit', [GroupController::class, 'edit'])->name('dashboard.groups.edit');
    Route::put('/dashboard/groups/{id}', [GroupController::class, 'update'])->name('dashboard.groups.update');

    // Tagok kezelése
    Route::delete('/dashboard/groups/{group_id}/kick/{user_id}', [GroupController::class, 'kickFromGroup'])->name('dashboard.groups.kick');
    Route::post('/dashboard/applications/{id}/accept', [ApplicationsController::class, 'accept'])->name('application.accept');
    Route::post('/dashboard/applications/{id}/reject', [ApplicationsController::class, 'reject'])->name('application.reject');
    Route::post('/dashboard/applications', [ApplicationsController::class, 'store'])->name('application.store');
});

// ----- Tag Útvonalak -----
Route::middleware(['auth', 'verified', 'checkRole:vendeg,tag'])->group(function () {

});

// ----- Vendég Útvonalak -----
Route::middleware(['auth', 'verified', 'checkRole:vendeg'])->group(function () {
    Route::get('/dashboard', [PostsController::class, 'index'])->name('dashboard');  // Dashboard Főoldal

    Route::get('/dashboard/groups', [GroupController::class, 'index'])->name('dashboard.groups.index'); // Csoportok oldal
    Route::get('/dashboard/groups/{id}', [GroupController::class, 'show'])->name('dashboard.groups.show'); // Csoport megtekintése

    Route::get('/dashboard/applications', [ApplicationsController::class, 'index'])->name('dashboard.application.index');
    Route::delete('/dashboard/applications/{id}', [ApplicationsController::class, 'destroy'])->name('dashboard.application.destroy');

    Route::get('/dashboard/posts', [PostsController::class, 'index'])->name('dashboard.posts.index');
    // Route::get('/dashboard/posts/{id}', [PostsController::class, 'show'])->name('dashboard.posts.show');

    Route::get('/dashboard/images', [ImageController::class, 'index'])->name('images.index');
    Route::get('/dashboard/images/create', [ImageController::class, 'create'])->name('images.create');
    Route::post('/dashboard/images', [ImageController::class, 'store'])->name('images.store');
    Route::delete('/dashboard/images/{id}', [ImageController::class, 'destroy'])->name('images.destroy');
});

// ----- Működésért felelős útvonalak -----
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard/search-leaders', [GroupController::class, 'searchLeaders']);

    Route::post('/dashboard/groups/{groupId}/join', [UserController::class, 'joinGroup'])->name('groups.join');
    Route::post('/dashboard/groups/{groupId}/leave', [UserController::class, 'leaveGroup'])->name('groups.leave');
});

// ----- Auth -----
Route::middleware('auth')->group(function () {
    Route::get('/dashboard/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/dashboard/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/dashboard/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';