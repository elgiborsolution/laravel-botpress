<?php

namespace ESolution\Botpress\Tests\Unit;

use ESolution\Botpress\Tests\BotpressTestCase;
use ESolution\Botpress\BotpressService;
use Illuminate\Support\Facades\DB;

class ConfigurationTest extends BotpressTestCase
{
    /** @test */
    public function it_resolves_config_from_env_by_default()
    {
        config(['botpress.server_url' => 'http://env-url.com']);

        $service = new BotpressService();
        $this->assertEquals('http://env-url.com', $service->getServerUrl());
    }

    /** @test */
    public function it_resolves_config_from_database_when_enabled()
    {
        config([
            'botpress.use_database_config' => true,
            'botpress.server_url' => 'http://env-url.com'
        ]);

        DB::table('botpress_configs')->insert([
            'key' => 'server_url',
            'value' => 'http://db-url.com'
        ]);

        $service = new BotpressService();
        $this->assertEquals('http://db-url.com', $service->getServerUrl());
    }
}
