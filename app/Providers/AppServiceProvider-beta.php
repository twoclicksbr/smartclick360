<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\App;
use Illuminate\Console\Scheduling\Schedule;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        date_default_timezone_set('America/Sao_Paulo'); // garante no PHP
        DB::statement("SET time_zone = '-03:00'");
        config(['app.timezone' => 'America/Sao_Paulo']); // reforça no Laravel
        Carbon::setLocale('pt_BR'); // opcional, para formatação

        if (App::runningInConsole()) {
            $this->app->booted(function () {
                $schedule = app(Schedule::class);
                $schedule->command('tokens:clear-expired')->twiceDaily(7, 19);
            });
        }
    }
}
