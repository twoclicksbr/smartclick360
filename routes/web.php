<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/debug-timezone', function () {
    $timezone = DB::select("SELECT @@session.time_zone as tz")[0]->tz;
    return [
        'agora' => now()->toDateTimeString(),
        'timezone_mysql' => $timezone,
    ];
});

Route::get('/credential-time', function () {
    return \App\Models\Api\Credential::find(1);
});
