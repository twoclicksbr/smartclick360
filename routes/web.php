<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\LoginViewController;
use App\Http\Middleware\CheckSession;

use App\Http\Controllers\Sys\CredentialController;

Route::get('/', function () {
    return view('metronic.site.landing');
});

Route::get('/auth/login', function () {
    return view('metronic.auth.login');
});

Route::post('/auth/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/auth/logout', [AuthController::class, 'logout'])->name('auth.logout');
Route::get('/auth/login', [LoginViewController::class, 'show'])->name('auth.login');

Route::get('/auth/lock', function () {
    return view('metronic.auth.lock-screen');
})->name('auth.lock');

Route::post('/auth/unlock', [AuthController::class, 'unlock'])->name('unlock');

Route::middleware([CheckSession::class])->prefix('sys')->group(function () {
    Route::get('/', fn() => view('metronic.system.home'))->name('sys.home');

    Route::get('/credential', [CredentialController::class, 'index'])->name('sys.credential.index');




    // Proxy universal para qualquer chamada de API
    Route::match(['get', 'post', 'put', 'delete'], '/api/{path}', fn() => null)->where('path', '.*');
});
