<?php

use Illuminate\Support\Str;
use Illuminate\Database\DBAL\TimestampType;

return [

    /*
    |--------------------------------------------------------------------------
    | Default Database Connection Name
    |--------------------------------------------------------------------------
    |
    | Here you may specify which of the database connections below you wish
    | to use as your default connection for all database work. Of course
    | you may use many connections at once using the Database library.
    |
     */

    'default' => env('DB_CONNECTION', 'mysql'),

    /*
    |--------------------------------------------------------------------------
    | Database Connections
    |--------------------------------------------------------------------------
    |
    | Here are each of the database connections setup for your application.
    | Of course, examples of configuring each database platform that is
    | supported by Laravel is shown below to make development simple.
    |
    |
    | All database work in Laravel is done through the PHP PDO facilities
    | so make sure you have the driver for your particular database of
    | choice installed on your machine before you begin development.
    |
     */

    'connections' => [

        'sqlite' => [
            'driver' => 'sqlite',
            'url' => env('DATABASE_URL'),
            'database' => env('DB_DATABASE', database_path('database.sqlite')),
            'prefix' => '',
            'foreign_key_constraints' => env('DB_FOREIGN_KEYS', true),
        ],

        'mysql' => [
            'driver' => 'mysql',
            'url' => env('DATABASE_URL'),
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '3306'),
            'database' => env('DB_DATABASE', 'forge'),
            'username' => env('DB_USERNAME', 'forge'),
            'password' => env('DB_PASSWORD', ''),
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
            ]) : [],
        ],

        'pgsql' => [
            'driver' => 'pgsql',
            'url' => env('DATABASE_URL'),
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '5432'),
            'database' => env('DB_DATABASE', 'forge'),
            'username' => env('DB_USERNAME', 'forge'),
            'password' => env('DB_PASSWORD', ''),
            'charset' => 'utf8',
            'prefix' => '',
            'prefix_indexes' => true,
            'schema' => 'public',
            'sslmode' => 'prefer',
        ],

        'sqlsrv' => [
            'driver' => 'sqlsrv',
            'url' => env('DATABASE_URL'),
            'host' => env('DB_HOST', 'localhost'),
            'port' => env('DB_PORT', '1433'),
            'database' => env('DB_DATABASE', 'forge'),
            'username' => env('DB_USERNAME', 'forge'),
            'password' => env('DB_PASSWORD', ''),
            'charset' => 'utf8',
            'prefix' => '',
            'prefix_indexes' => true,
        ],

        'oracle' => [
            'driver' => 'oracle',
            'host' => env('DB_HOST_ORACLE', 'localhost'),
            'port' => env('DB_PORT_ORACLE', '1521'),
            'database' => env('DB_DATABASE_ORACLE', 'forge'),
            'service_name' => env('DB_DATABASE_ORACLE', 'forge'),
            'username' => env('DB_USERNAME_ORACLE', 'forge'),
            'password' => env('DB_PASSWORD_ORACLE', ''),
            'charset' => 'AL32UTF8',
            'prefix' => '',
            'strict' => false,
        ],

        'oracle_oaie' => [
            'driver' => 'oracle',
            'host' => env('DB_HOST_ORACLE_OAIE', 'localhost'),
            'port' => env('DB_PORT_ORACLE_OAIE', '1521'),
            'database' => env('DB_DATABASE_ORACLE_OAIE', 'forge'),
            'service_name' => env('DB_DATABASE_ORACLE_OAIE', 'forge'),
            'username' => env('DB_USERNAME_ORACLE_OAIE', 'forge'),
            'password' => env('DB_PASSWORD_ORACLE_OAIE', ''),
            'charset' => 'AL32UTF8',
            'prefix' => '',
            'strict' => false,
        ],

        'oracle_oapm' => [
            'driver' => 'oracle',
            'host' => env('DB_HOST_ORACLE_OAPM', 'localhost'),
            'port' => env('DB_PORT_ORACLE_OAPM', '1521'),
            'database' => env('DB_DATABASE_ORACLE_OAPM', 'forge'),
            'service_name' => env('DB_DATABASE_ORACLE_OAPM', 'forge'),
            'username' => env('DB_USERNAME_ORACLE_OAPM', 'forge'),
            'password' => env('DB_PASSWORD_ORACLE_OAPM', ''),
            'charset' => 'AL32UTF8',
            'prefix' => '',
            'strict' => false,
        ],

        'oracle_oapm' => [
            'driver' => 'oracle',
            'host' => env('DB_HOST_ORACLE_OAPM', 'localhost'),
            'port' => env('DB_PORT_ORACLE_OAPM', '1521'),
            'database' => env('DB_DATABASE_ORACLE_OAPM', 'forge'),
            'service_name' => env('DB_DATABASE_ORACLE_OAPM', 'forge'),
            'username' => env('DB_USERNAME_ORACLE_OAPM', 'forge'),
            'password' => env('DB_PASSWORD_ORACLE_OAPM', ''),
            'charset' => 'AL32UTF8',
            'prefix' => '',
        ],

        'oracle_toat' => [
            'driver' => 'oracle',
            'host' => env('DB_HOST_ORACLE_TOAT', 'localhost'),
            'port' => env('DB_PORT_ORACLE_TOAT', '1521'),
            'database' => env('DB_DATABASE_ORACLE_TOAT', 'forge'),
            'service_name' => env('DB_DATABASE_ORACLE_TOAT', 'forge'),
            'username' => env('DB_USERNAME_ORACLE_TOAT', 'forge'),
            'password' => env('DB_PASSWORD_ORACLE_TOAT', ''),
            'charset' => 'AL32UTF8',
            'prefix' => '',
            'strict' => false,
        ],

        'oracle_oapp' => [
            'driver' => 'oracle',
            'host' => env('DB_HOST_ORACLE_OAPP', 'localhost'),
            'port' => env('DB_PORT_ORACLE_OAPP', '1521'),
            'database' => env('DB_DATABASE_ORACLE_OAPP', 'forge'),
            'service_name' => env('DB_DATABASE_ORACLE_OAPP', 'forge'),
            'username' => env('DB_USERNAME_ORACLE_OAPP', 'forge'),
            'password' => env('DB_PASSWORD_ORACLE_OAPP', ''),
            'charset' => 'AL32UTF8',
            'prefix' => '',
            'strict' => false,
        ],

        'oracle_oair' => [
            'driver' => 'oracle',
            'host' => env('DB_HOST_ORACLE_OAIR', 'localhost'),
            'port' => env('DB_PORT_ORACLE_OAIR', '1521'),
            'database' => env('DB_DATABASE_ORACLE_OAIR', 'forge'),
            'service_name' => env('DB_DATABASE_ORACLE_OAIR', 'forge'),
            'username' => env('DB_USERNAME_ORACLE_OAIR', 'forge'),
            'password' => env('DB_PASSWORD_ORACLE_OAIR', ''),
        ],

        'oracle_oact' => [
            'driver' => 'oracle',
            'host' => env('DB_HOST_ORACLE_OACT', 'localhost'),
            'port' => env('DB_PORT_ORACLE_OACT', '1521'),
            'database' => env('DB_DATABASE_ORACLE_OACT', 'forge'),
            'service_name' => env('DB_DATABASE_ORACLE_OACT', 'forge'),
            'username' => env('DB_USERNAME_ORACLE_OACT', 'forge'),
            'password' => env('DB_PASSWORD_ORACLE_OACT', ''),
            'charset' => 'AL32UTF8',
            'prefix' => '',
            'strict' => false,
        ],

        'oracle_oaom' => [
            'driver' => 'oracle',
            'host' => env('DB_HOST_ORACLE_OAOM', 'localhost'),
            'port' => env('DB_PORT_ORACLE_OAOM', '1521'),
            'database' => env('DB_DATABASE_ORACLE_OAOM', 'forge'),
            'service_name' => env('DB_DATABASE_ORACLE_OAOM', 'forge'),
            'username' => env('DB_USERNAME_ORACLE_OAOM', 'forge'),
            'password' => env('DB_PASSWORD_ORACLE_OAOM', ''),
            'charset' => 'AL32UTF8',
            'prefix' => '',
            'strict' => false,
        ],

        'oracle_oact' => [
            'driver' => 'oracle',
            'host' => env('DB_HOST_ORACLE_OACT', 'localhost'),
            'port' => env('DB_PORT_ORACLE_OACT', '1521'),
            'database' => env('DB_DATABASE_ORACLE_OACT', 'forge'),
            'service_name' => env('DB_DATABASE_ORACLE_OACT', 'forge'),
            'username' => env('DB_USERNAME_ORACLE_OACT', 'forge'),
            'password' => env('DB_PASSWORD_ORACLE_OACT', ''),
            'charset' => 'AL32UTF8',
            'prefix' => '',
        ],

        'oracle_oaom' => [
            'driver' => 'oracle',
            'host' => env('DB_HOST_ORACLE_OAOM', 'localhost'),
            'port' => env('DB_PORT_ORACLE_OAOM', '1521'),
            'database' => env('DB_DATABASE_ORACLE_OAOM', 'forge'),
            'service_name' => env('DB_DATABASE_ORACLE_OAOM', 'forge'),
            'username' => env('DB_USERNAME_ORACLE_OAOM', 'forge'),
            'password' => env('DB_PASSWORD_ORACLE_OAOM', ''),
            'charset' => 'AL32UTF8',
            'prefix' => '',
        ],
        'oracle_oainv' => [
            'driver' => 'oracle',
            'host' => env('DB_HOST_ORACLE_OAINV', 'localhost'),
            'port' => env('DB_PORT_ORACLE_OAINV', '1521'),
            'database' => env('DB_DATABASE_ORACLE_OAINV', 'forge'),
            'service_name' => env('DB_DATABASE_ORACLE_OAINV', 'forge'),
            'username' => env('DB_USERNAME_ORACLE_OAINV', 'forge'),
            'password' => env('DB_PASSWORD_ORACLE_OAINV', ''),
            'charset' => 'AL32UTF8',
            'prefix' => '',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Migration Repository Table
    |--------------------------------------------------------------------------
    |
    | This table keeps track of all the migrations that have already run for
    | your application. Using this information, we can determine which of
    | the migrations on disk haven't actually been run in the database.
    |
     */

    'migrations' => 'ptw_migrations',

    /*
    |--------------------------------------------------------------------------
    | Redis Databases
    |--------------------------------------------------------------------------
    |
    | Redis is an open source, fast, and advanced key-value store that also
    | provides a richer body of commands than a typical key-value system
    | such as APC or Memcached. Laravel makes it easy to dig right in.
    |
     */

    'redis' => [

        'client' => env('REDIS_CLIENT', 'phpredis'),

        'options' => [
            'cluster' => env('REDIS_CLUSTER', 'redis'),
            'prefix' => env('REDIS_PREFIX', Str::slug(env('APP_NAME', 'laravel'), '_') . '_database_'),
        ],

        'default' => [
            'url' => env('REDIS_URL'),
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'password' => env('REDIS_PASSWORD', null),
            'port' => env('REDIS_PORT', '6379'),
            'database' => env('REDIS_DB', '0'),
        ],

        'cache' => [
            'url' => env('REDIS_URL'),
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'password' => env('REDIS_PASSWORD', null),
            'port' => env('REDIS_PORT', '6379'),
            'database' => env('REDIS_CACHE_DB', '1'),
        ],

    ],
    

    'dbal' => [
        'types' => [
            'timestamp' => TimestampType::class,
        ],
    ],

];
