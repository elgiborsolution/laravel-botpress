<?php

namespace ESolution\Botpress;

use Illuminate\Support\ServiceProvider;

class BotpressServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/botpress.php',
            'botpress'
        );

        $this->app->singleton(BotpressService::class, function ($app) {
            return new BotpressService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/botpress.php' => config_path('botpress.php'),
            ], 'botpress-config');

            if (!class_exists('CreateBotpressConfigsTable')) {
                $this->publishes([
                    __DIR__ . '/../database/migrations/create_botpress_configs_table.php.stub' => database_path('migrations/' . date('Y_m_d_His', time()) . '_create_botpress_configs_table.php'),
                ], 'botpress-migrations');
            }
        }

        $this->loadRoutesFrom(__DIR__ . '/../routes/api.php');
    }
}
