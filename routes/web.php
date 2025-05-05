<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Middleware\CheckSession;

#### Site
Route::get('/', fn() => view('welcome'));

#### Login
Route::get('/login', fn() => view('auth.login'));
Route::post('/login', [AuthController::class, 'login'])->name('auth.login');

#### Bloquear
Route::get('/lock', function () {
    session(['locked' => true]);
    return redirect()->route('auth.lock.screen');
})->name('auth.lock');

Route::view('/auth/lock-screen', 'auth.lockscreen')->name('auth.lock.screen');
Route::post('/auth/unlock', [AuthController::class, 'unlock'])->name('auth.unlock');


#### Logout
Route::get('/logout', function () {
    session()->flush();
    return redirect('/login')->with('success', 'Desconectado com sucesso.');
})->name('logout');



#### Rotas Admin
Route::middleware([CheckSession::class])->prefix('admin')->group(function () {
    Route::view('/home', 'admin.home');
});
