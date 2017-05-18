<?php

return [

    /*
    |--------------------------------------------------------------------------
    | PDO Fetch Style
    |--------------------------------------------------------------------------
    |
    | By default, database results will be returned as instances of the PHP
    | stdClass object; however, you may desire to retrieve records in an
    | array format for simplicity. Here you can tweak the fetch style.
    |
    */

    'fetch' => PDO::FETCH_ASSOC,

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
    | Определяем требуется ли логирование SQL запросов
    |--------------------------------------------------------------------------
    |
    | Здесь вы можете определить нужно ли логировать SQL запросы к базе данных.
    |
    */

    'log' => true,

    /*
    |--------------------------------------------------------------------------
    | Определяем время после которого запрос к базе данных считается медленным
    |--------------------------------------------------------------------------
    |
    | Если вы установили параметр log в значение true, то вы можете установить
    | в этом параметре количество секунд, после которых считается, что запрос
    | был медленным, и значит, только эти запросы будут записаны в лог. Если параметр
    | установлен в 0, то все запросы попадут в лог, в независимости от их скорости
    | исполнения. Не советуем ставить это параметр в значение 0, т.к. лог файлы
    | через незначительное время будут переполнены логами.
    |
    */

    'timeSlow' => 2,

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
            'database' => env('DB_SQLITE_DATABASE', database_path('database.sqlite')),
            'prefix' => '',
        ],

        'mysql' => [
            'driver' => 'mysql',
            'host' => env('DB_MYSQL_HOST', 'localhost'),
            'port' => env('DB_MYSQL_PORT', '3306'),
            'database' => env('DB_MYSQL_DATABASE'),
            'username' => env('DB_MYSQL_USERNAME'),
            'password' => env('DB_MYSQL_PASSWORD'),
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => null,
        ],

        'pgsql' => [
            'driver' => 'pgsql',
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '5432'),
            'database' => env('DB_DATABASE'),
            'username' => env('DB_USERNAME'),
            'password' => env('DB_PASSWORD'),
            'charset' => 'utf8',
            'prefix' => '',
            'schema' => 'public',
            'sslmode' => 'prefer',
        ],

        'mongodb' => [
            'driver'   => 'mongodb',
            'host'     => env('DB_MONGODB_HOST', 'localhost'),
            'port'     => env('DB_MONGODB_PORT', 27017),
            'database' => env('DB_MONGODB_DATABASE'),
            'username' => env('DB_MONGODB_USERNAME'),
            'password' => env('DB_MONGODB_PASSWORD'),
            'name' => 'mongodb',
            'options'  => [
                'database' => 'admin' // sets the authentication database required by mongo 3
            ]
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

    'migrations' => 'migrations',

    /*
    |--------------------------------------------------------------------------
    | Redis Databases
    |--------------------------------------------------------------------------
    |
    | Redis is an open source, fast, and advanced key-value store that also
    | provides a richer set of commands than a typical key-value systems
    | such as APC or Memcached. Laravel makes it easy to dig right in.
    |
    */

    'redis' => [

        'cluster' => env('REDIS_CLUSTER', false),

        'default' => [
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'password' => env('REDIS_PASSWORD'),
            'port' => env('REDIS_PORT', 6379),
            'database' => env('REDIS_DATABASE', 0)
        ],

    ],

];
