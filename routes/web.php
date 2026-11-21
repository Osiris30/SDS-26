<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AdminSessionController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\AdminPostController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\PublicPostController;

Route::get('/', [PublicPostController::class, 'index'])->name('home');
Route::view('/semana-2026', 'event.index')->name('event');
Route::get('/publicaciones/{slug}', [PublicPostController::class, 'show'])->name('posts.show');
Route::get('/iniciar-sesion', [AdminSessionController::class, 'create'])->name('login');
Route::post('/iniciar-sesion', [AdminSessionController::class, 'store'])->middleware('throttle:5,1')->name('login.store');
Route::post('/cerrar-sesion', [AdminSessionController::class, 'destroy'])->middleware('auth')->name('logout');

Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', AdminDashboardController::class)->name('dashboard');
    Route::resource('categorias', CategoryController::class)->names('categories')->except('show');
    Route::resource('publicaciones', AdminPostController::class)->names('posts')->parameters(['publicaciones' => 'post'])->except('show');
});
