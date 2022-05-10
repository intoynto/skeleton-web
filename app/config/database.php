<?php
return [    
    "default"=> "postgres",
    'postgres'=>[
        'driver' =>'pgsql',
        "host" => "localhost",
        'port' => 5432,
        'database' => 'dbmon3v',
        'username' => 'postgres',
        'password' => '12345678',
        'charset' => 'utf8', // MySQL = utf8mb4 , Postgres = utf8
        'collation' => 'utf8mb4_unicode_ci', // MySQL = utf8mb4_unicode_ci , Postgres = utf8_unicode_ci
        'timezone'=>'Asia/Makassar',
        'options' => [
            // Turn off persistent connections
            PDO::ATTR_PERSISTENT => false,
            // Enable exceptions
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            // Emulate prepared statements
            PDO::ATTR_EMULATE_PREPARES => true,
            // Set default fetch mode to object
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,              
            // Set character set
            //PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci'   // for mysql
        ],
    ],
    'mysql'=>[
        'driver' =>'mysql',
        "host" => "localhost",
        'port' => 3306,
        'database' => 'dbmon3v',
        'username' => 'root',
        'password' => null,
        'charset' => 'utf8mb4', // MySQL = utf8mb4 , Postgres = utf8
        'collation' => 'utf8mb4_unicode_ci', // MySQL = utf8mb4_unicode_ci , Postgres = utf8_unicode_ci
        'options' => [
            // Turn off persistent connections
            PDO::ATTR_PERSISTENT => false,
            // Enable exceptions
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            // Emulate prepared statements
            PDO::ATTR_EMULATE_PREPARES => true,
            // Set default fetch mode to object
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,              
            // Set character set
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci'   // for mysql
        ],
    ],
];