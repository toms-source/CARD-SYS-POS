<?php

use Illuminate\Support\Facades\Auth;
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

Route::get('/', function () {
    return view('livewire.landing');
});

Route::get('/inventory', function () {
    return view('home');
})->name('inventory');

Route::get('/pos', function () {
    return view('livewire.sale-management');
})->name('pos');


Route::prefix('')->group(function () {
    Route::get('/register', function () {
        return view('livewire.client.register');})->name('client.register');
    Route::get('/login', function () {
        return view('livewire.client.login');})->name('client.login');
});

// Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
