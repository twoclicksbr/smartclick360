<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', fn() => view('welcome'));
Route::get('/login', fn() => view('auth.login'));
Route::post('/login', [AuthController::class, 'login'])->name('auth.login');

Route::view('/admin/home', 'admin.home')->middleware('web');
