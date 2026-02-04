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

    /*
    |--------------------------------------------------------------------------
    | Authentication Type
    |--------------------------------------------------------------------------
    |
    | The authentication method to use with your Botpress instance.
    | Options: 'bearer' (Cloud), 'jwt' (CE), 'basic' (CE), 'none' (CE dev)
    |
    */
    'auth_type' => env('BOTPRESS_AUTH_TYPE', 'basic'),

    /*
    |--------------------------------------------------------------------------
    | JWT Authentication Settings (for Botpress CE)
    |--------------------------------------------------------------------------
    |
    | JWT secret key for generating tokens when using Botpress CE with JWT auth.
    | JWT expiry time in seconds (default: 1 hour).
    |
    */
    'auth_secret' => env('BOTPRESS_AUTH_SECRET'),
    'jwt_expiry' => env('BOTPRESS_JWT_EXPIRY', 3600),

    /*
    |--------------------------------------------------------------------------
    | Basic Authentication Settings (for Botpress CE)
    |--------------------------------------------------------------------------
    |
    | Username and password for basic authentication with Botpress CE.
    |
    */
    'auth_username' => env('BOTPRESS_AUTH_USERNAME'),
    'auth_password' => env('BOTPRESS_AUTH_PASSWORD'),
];
