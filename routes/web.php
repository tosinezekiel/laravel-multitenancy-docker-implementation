<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
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
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::domain('{subdomain}.propel.test')->middleware(['tenant.identifier'])->group(function () {
    Route::get('/login', [LoginController::class, 'login'])->name('tenant.login');
    Route::get('/register', [RegisterController::class, 'register'])->name('tenant.register');
    Route::get('/tenants/dashboard', [App\Http\Controllers\Tenants\HomeController::class, 'index']);
});
