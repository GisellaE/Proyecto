<?php

use App\Models\User;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StoreController;

// Página de bienvenida
Route::get('/', function () {
    return Inertia::render('Home', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
})->name('home');

// Página principal con productos destacados
Route::get('/home', [HomeController::class, 'index'])->name('home');

// RUTAS PÚBLICAS DE PRODUCTOS
Route::get('/products', [ProductController::class, 'index'])->name('products.index');

// RUTAS PÚBLICAS DE CATEGORÍAS
Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');

// RUTAS ESPECÍFICAS DE CATEGORÍAS (van ANTES que las dinámicas)
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {

    // CRUD de productos (admin/gestión) - PRIMERO las rutas específicas
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    Route::get('/products/{slug}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{slug}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{slug}', [ProductController::class, 'destroy'])->name('products.destroy');

    // RUTAS ESPECÍFICAS DE CATEGORÍAS
    Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('/categories/{slug}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::put('/categories/{slug}', [CategoryController::class, 'update'])->name('categories.update');

    Route::put('/categories/{slug}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{slug}', [CategoryController::class, 'destroy'])->name('categories.destroy');
    Route::patch('/categories/{slug}/toggle-status', [CategoryController::class, 'toggleStatus'])->name('categories.toggleStatus');
});


// Ruta pública para mostrar individual (va AL FINAL)
Route::get('/products/{slug}', [ProductController::class, 'show'])->name('products.show');
Route::get('/categories/{slug}', [CategoryController::class, 'show'])->name('categories.show');

// Rutas que requieren autenticación
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {

    // Rutas de perfil
    // Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    // Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    // Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    // Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
    // Route::delete('/profile/avatar', [ProfileController::class, 'deleteAvatar'])->name('profile.avatar.delete');
});
