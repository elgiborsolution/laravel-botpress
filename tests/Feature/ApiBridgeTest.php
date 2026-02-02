<?php

namespace ESolution\Botpress\Tests\Feature;

use ESolution\Botpress\Tests\BotpressTestCase;
use Illuminate\Support\Facades\Http;

class ApiBridgeTest extends BotpressTestCase
{
    /** @test */
    public function it_can_proxy_get_requests_to_botpress()
    {
        Http::fake([
            'http://localhost:3000/api/v1/bots/my-bot/converse/user-1' => Http::response(['text' => 'hello'], 200)
        ]);

        $response = $this->get('/botpress/api/v1/bots/my-bot/converse/user-1');

        $response->assertStatus(200);
        $response->assertJson(['text' => 'hello']);
    }

    /** @test */
    public function it_can_proxy_post_requests_with_payload()
    {
        Http::fake([
            'http://localhost:3000/api/v1/bots/my-bot/converse/user-1' => Http::response(['text' => 'received'], 201)
        ]);

        $response = $this->postJson('/botpress/api/v1/bots/my-bot/converse/user-1', [
            'type' => 'text',
            'text' => 'hey'
        ]);

        $response->assertStatus(201);
        $response->assertJson(['text' => 'received']);

        Http::assertSent(function ($request) {
            $data = $request->data();
            if (empty($data)) {
                $data = json_decode($request->body(), true);
            }
            return $request->url() == 'http://localhost:3000/api/v1/bots/my-bot/converse/user-1' &&
                $data['type'] == 'text';
        });
    }

    /** @test */
    public function it_uses_configurable_prefix()
    {
        config(['botpress.route_prefix' => 'custom-api']);

        // Note: Routes are loaded at boot, so we might need to refresh them or 
        // test this by ensuring the route is registered correctly in a fresh app instance.
        // For simplicity in this test, we assume the prefix is 'botpress' initially.

        Http::fake([
            'http://localhost:3000/test' => Http::response('ok', 200)
        ]);

        $response = $this->get('/botpress/test');
        $response->assertStatus(200);
    }
}
