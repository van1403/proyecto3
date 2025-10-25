<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\CartController;
use Illuminate\Support\Facades\Route;

// Página de inicio
Route::get('/', function () {
    return view('welcome');
});

// Autenticación
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Rutas de Administrador
Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    
    // Categorías
    Route::get('/categories', [AdminController::class, 'categories'])->name('admin.categories');
    Route::get('/categories/create', [AdminController::class, 'createCategory'])->name('admin.categories.create');
    Route::post('/categories', [AdminController::class, 'storeCategory'])->name('admin.categories.store');
    Route::get('/categories/{category}/edit', [AdminController::class, 'editCategory'])->name('admin.categories.edit');
    Route::put('/categories/{category}', [AdminController::class, 'updateCategory'])->name('admin.categories.update');
    Route::delete('/categories/{category}', [AdminController::class, 'destroyCategory'])->name('admin.categories.destroy');
    
    // Proveedores
    Route::get('/suppliers', [AdminController::class, 'suppliers'])->name('admin.suppliers');
    Route::get('/suppliers/create', [AdminController::class, 'createSupplier'])->name('admin.suppliers.create');
    Route::post('/suppliers', [AdminController::class, 'storeSupplier'])->name('admin.suppliers.store');
    Route::get('/suppliers/{supplier}/edit', [AdminController::class, 'editSupplier'])->name('admin.suppliers.edit');
    Route::put('/suppliers/{supplier}', [AdminController::class, 'updateSupplier'])->name('admin.suppliers.update');
    Route::delete('/suppliers/{supplier}', [AdminController::class, 'destroySupplier'])->name('admin.suppliers.destroy');
    
    // Productos
    Route::get('/products', [AdminController::class, 'products'])->name('admin.products');
    Route::get('/products/create', [AdminController::class, 'createProduct'])->name('admin.products.create');
    Route::post('/products', [AdminController::class, 'storeProduct'])->name('admin.products.store');
    Route::get('/products/{product}/edit', [AdminController::class, 'editProduct'])->name('admin.products.edit');
    Route::put('/products/{product}', [AdminController::class, 'updateProduct'])->name('admin.products.update');
    Route::delete('/products/{product}', [AdminController::class, 'destroyProduct'])->name('admin.products.destroy');
    
    // Ventas
    Route::get('/sales', [AdminController::class, 'sales'])->name('admin.sales');
});

// Rutas de Cliente
    Route::prefix('client')->middleware(['auth', 'client'])->group(function () {
    Route::get('/dashboard', [ClientController::class, 'dashboard'])->name('client.dashboard');
    Route::get('/products/category/{category}', [ClientController::class, 'productsByCategory'])->name('client.products.by-category');
    Route::get('/products/{product}', [ClientController::class, 'showProduct'])->name('client.product.show');
    Route::post('/products/{product}/purchase', [ClientController::class, 'purchaseProduct'])->name('client.product.purchase');
    Route::get('/purchase-history', [ClientController::class, 'purchaseHistory'])->name('client.purchase-history');
    Route::get('/purchase/{id}', [ClientController::class, 'showPurchase'])->name('client.purchase.show');
    Route::get('/purchase/{id}/receipt', [ClientController::class, 'generateReceipt'])->name('client.purchase.receipt');

    Route::get('/payment/{product}', [ClientController::class, 'showPayment'])->name('client.showPayment');
    Route::post('/payment/{product}', [ClientController::class, 'processPayment'])->name('client.processPayment');
    Route::get('/checkout/{product}', [ClientController::class, 'showCheckout'])->name('client.showCheckout');
    Route::post('/checkout/{product}', [ClientController::class, 'processCheckout'])->name('client.processCheckout');
    });

    Route::prefix('cart')->middleware(['auth', 'client'])->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('cart.index');
    Route::post('/add/{product}', [CartController::class, 'add'])->name('cart.add');
    Route::delete('/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
    Route::delete('/clear', [CartController::class, 'clear'])->name('cart.clear');
    
 
});
