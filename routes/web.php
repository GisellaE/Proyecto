<?php

use App\Models\User;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\StoreController;




// Rutas para gestionar categorías (requiere autenticación)
Route::middleware(['auth'])->group(function () {
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
});


// Página de bienvenida (solo se ve si no estás autenticado)
Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
})->name('welcome');

// Página principal con productos y categorías (para usuarios no autenticados también)
Route::get('/home', [HomeController::class, 'index'])->name('home');

// CRUD de productos solo para autenticados
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {

    // Rutas de productos (excepto 'show')
    Route::resource('products', ProductController::class)->except(['show'])->parameters([
        'products' => 'product:slug',
    ]);

    // Ruta para ver el producto individual (pública, no requiere autenticación)
    Route::get('/products/{slug}', [ProductController::class, 'show'])->name('products.show');

    // Rutas de categorías
    Route::resource('categories', CategoryController::class)->parameters([
        'categories' => 'category:slug',
    ]);
});




