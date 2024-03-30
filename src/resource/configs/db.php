<?php

    use Coco\env\EnvParser;

    return [
        "db" => [
            "host" => EnvParser::get('DB_HOST', '127.0.0.1'),
            "name" => EnvParser::get('DB_NAME', 'test'),
            "user" => EnvParser::get('DB_USER', 'root'),
            "pass" => EnvParser::get('DB_PASS', ''),
            "port" => EnvParser::get('DB_PORT', 3306),


            'enable_redis_cache' => false,
            'redis_cache_index'  => 12,
            'redis_cache_prefix' => 'coco_mysql_cache',

            "charset"           => EnvParser::get('DB_CHARSET', 'utf8'),
            "type"              => EnvParser::get('DB_TYPE', 'mysql'),
            'params'            => [],
            'fields_cache'      => true,
            'schema_cache_path' => 'data',
        ],
    ];