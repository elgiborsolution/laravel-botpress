<?php

namespace ESolution\Botpress\Tests;

use ESolution\Botpress\BotpressServiceProvider;
use Orchestra\Testbench\TestCase;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BotpressTestCase extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [
            BotpressServiceProvider::class,
        ];
    }

    protected function defineDatabaseMigrations()
    {
        $this->loadLaravelMigrations();

        // Load our stubbed migration
        if (!class_exists('CreateBotpressConfigsTable')) {
            require_once __DIR__ . '/../database/migrations/create_botpress_configs_table.php.stub';
        }

        $migrationClass = '\CreateBotpressConfigsTable';
        (new $migrationClass())->up();
    }
}
