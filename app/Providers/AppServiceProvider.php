<?php

namespace App\Providers;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        if (empty(config('app.key'))) {
            config(['app.key' => 'base64:bW1X54LPQUCzjftKBU6HwZjlWWaFa91WRuwRhRouLQg=']);
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Resilient database connection fallback:
        // If MySQL is configured but unreachable (e.g. on Wasmer, cloud serverless without local MySQL daemon),
        // gracefully fall back to the pre-seeded SQLite database so the app never throws QueryException.
        if (config('database.default') === 'mysql') {
            try {
                DB::connection('mysql')->getPdo();
            } catch (\Throwable $e) {
                Config::set('database.default', 'sqlite');
                Config::set('session.driver', 'file');
                Config::set('cache.default', 'file');
                DB::purge('mysql');
                DB::setDefaultConnection('sqlite');
            }
        }
    }
}

