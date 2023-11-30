<!-- routes/web.php -->

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\ToyController;
use App\Http\Controllers\TransaksiController;

//Autentikasi
// Change the route definition for the root path to accept POST requests
Route::get('/', [Controller::class, 'viewLogin'])->name('admin.login');
Route::post('/', [Controller::class, 'auth'])->name('auth');
Route::get('/login', [Controller::class, 'viewLogin']);
Route::get('/logout', [Controller::class, 'logout']);
Route::post('/logout', [Controller::class, 'logout']);

//Route Customer
Route::group(['middleware' => 'web'],function() {

Route::get('/customer', [CustomerController::class, 'index'])->name('customer.index');
Route::get('/customer/add', [CustomerController::class, 'create'])->name('customer.create');
Route::get('/customer/edit/{id}', [CustomerController::class, 'edit'])->name('customer.edit');
Route::post('/customer/update/{id}', [CustomerController::class, 'update'])->name('customer.update');
Route::post('/customer/delete/{id}', [CustomerController::class, 'delete'])->name('customer.delete');
Route::post('/customer/store', [CustomerController::class, 'store'])->name('customer.store');
Route::get('/customer/search', [CustomerController::class, 'search'])->name('customer.search');
Route::get('/customer/restore/search', [CustomerController::class, 'search_trash'])->name('customer.search_trash');
Route::get('/customer/recent', [CustomerController::class, 'softindex'])->name('customer.softindex');
Route::post('/customer/delete/{id}', [CustomerController::class, 'softdelete'])->name('customer.softdelete');
Route::get('/customer/restore/{id}', [CustomerController::class, 'restore'])->name('customer.restore');
Route::post('/customer/restore/delete/{id}', [CustomerController::class, 'delete'])->name('customer.delete');

//Route Toy
Route::get('/toy', [ToyController::class, 'index'])->name('toy.index');
Route::get('toy/add', [ToyController::class, 'create'])->name('toy.create');
Route::get('toy/edit/{id}', [ToyController::class, 'edit'])->name('toy.edit');
Route::post('toy/update/{id}', [ToyController::class, 'update'])->name('toy.update');
Route::post('toy/delete/{id}', [ToyController::class, 'delete'])->name('toy.delete');
Route::post('toystore', [ToyController::class, 'store'])->name('toy.store');
Route::get('/toy/search', [ToyController::class, 'search'])->name('toy.search');
Route::get('/toy/restore/search', [ToyController::class, 'search_trash'])->name('toy.search_trash');
Route::get('/toy/recent', [ToyController::class, 'softindex'])->name('toy.softindex');
Route::post('/toy/delete/{id}', [ToyController::class, 'softdelete'])->name('toy.softdelete');
Route::get('/toy/restore/{id}', [ToyController::class, 'restore'])->name('toy.restore');
Route::post('/toy/restore/delete/{id}', [ToyController::class, 'delete'])->name('toy.delete');

//Route Supplier
Route::get('/supplier', [SupplierController::class, 'index'])->name('supplier.index');
Route::get('/supplier/search', [SupplierController::class, 'search'])->name('supplier.search');
Route::get('/supplier/restore/search', [SupplierController::class, 'search_trash'])->name('supplier.search_trash');
Route::get('/supplier/recent', [SupplierController::class, 'softindex'])->name('supplier.softindex');
Route::get('/supplier/add', [SupplierController::class, 'create'])->name('supplier.create');
Route::get('/supplier/edit/{id}', [SupplierController::class, 'edit'])->name('supplier.edit');
Route::post('/supplier/update/{id}', [SupplierController::class, 'update'])->name('supplier.update');
Route::post('/supplier/delete/{id}', [SupplierController::class, 'softdelete'])->name('supplier.softdelete');
Route::post('/supplier/store', [SupplierController::class, 'store'])->name('supplier.store');
Route::get('/supplier/restore/{id}', [SupplierController::class, 'restore'])->name('supplier.restore');
Route::post('/supplier/restore/delete/{id}', [SupplierController::class, 'delete'])->name('supplier.delete');

//Route Transaksi
Route::post('/dashboard', [TransaksiController::class, 'index'])->name('transaksi.index');
Route::get('/dashboard', [TransaksiController::class, 'index'])->name('transaksi.index');
Route::get('/transaksi/search', [TransaksiController::class, 'search'])->name('transaksi.search');
Route::get('/transaksi/restore/search', [TransaksiController::class, 'search_trash'])->name('transaksi.search_trash');
Route::get('/transaksi/recent', [TransaksiController::class, 'softindex'])->name('transaksi.softindex');
Route::get('/transaksi/add', [TransaksiController::class, 'create'])->name('transaksi.create');
Route::get('/transaksi/edit/{id}', [TransaksiController::class, 'edit'])->name('transaksi.edit');
Route::post('/transaksi/update/{id}', [TransaksiController::class, 'update'])->name('transaksi.update');
Route::post('/transaksi/delete/{id}', [TransaksiController::class, 'softdelete'])->name('transaksi.softdelete');
Route::post('/transaksi/store', [TransaksiController::class, 'store'])->name('transaksi.store');
Route::get('/transaksi/restore/{id}', [TransaksiController::class, 'restore'])->name('transaksi.restore');
Route::post('/transaksi/restore/delete/{id}', [TransaksiController::class, 'delete'])->name('transaksi.delete');


});