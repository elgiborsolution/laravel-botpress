<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Botpress Server URL
    |--------------------------------------------------------------------------
    |
    | The base URL of your Botpress v12 Community Edition server.
    | e.g., http://localhost:3000
    |
    */
    'server_url' => env('BOTPRESS_SERVER_URL', 'http://localhost:3000'),

    /*
    |--------------------------------------------------------------------------
    | Botpress API Token
    |--------------------------------------------------------------------------
    |
    | Your Botpress Personal Access Token or Bot Token for authentication.
    |
    */
    'api_token' => env('BOTPRESS_API_TOKEN'),

    /*
    |--------------------------------------------------------------------------
    | API Bridge Route Prefix
    |--------------------------------------------------------------------------
    |
    | The prefix for the routes that will bridge to the Botpress API.
    | e.g., 'botpress' results in 'example.com/botpress/api/v1/...'
    |
    */
    'route_prefix' => env('BOTPRESS_ROUTE_PREFIX', 'botpress'),

    /*
    |--------------------------------------------------------------------------
    | Database Configuration Storage
    |--------------------------------------------------------------------------
    |
    | Whether to allow overriding configuration from the database.
    |
    */
    'use_database_config' => env('BOTPRESS_USE_DATABASE_CONFIG', false),

    /*
    |--------------------------------------------------------------------------
    | Database Table Name
    |--------------------------------------------------------------------------
    |
    | The name of the table used to store Botpress configurations.
    |
    */
    'table_name' => env('BOTPRESS_CONFIG_TABLE', 'botpress_configs'),
];
