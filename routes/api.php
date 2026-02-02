<?php

use Illuminate\Support\Facades\Route;
use ESolution\Botpress\Http\Controllers\BotpressBridgeController;

Route::group([
    'prefix' => config('botpress.route_prefix', 'botpress'),
    'middleware' => ['api'],
], function () {
    Route::any('{any}', [BotpressBridgeController::class, 'handle'])
        ->where('any', '.*');
});
