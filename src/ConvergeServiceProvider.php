<?php

namespace ChinLeung\Converge;

use Illuminate\Support\ServiceProvider;

class ConvergeServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/config.php' => config_path('converge.php'),
            ], 'config');
        }

        $this->app->bind(Client::class, static function () {
            return new Client(
                config('converge.merchant_id'),
                config('converge.user.id'),
                config('converge.user.pin'),
                config('converge.demo')
            );
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'converge');
    }
}
