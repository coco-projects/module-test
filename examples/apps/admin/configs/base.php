<?php

    use Coco\constants\Consts;
    use Coco\env\EnvParser;

    use Monolog\Handler\ErrorLogHandler;
    use Monolog\Handler\RotatingFileHandler;
    use Monolog\Level;

    return [
        "base" => [
            "app_debug" => EnvParser::get('APP_DEBUG', false),
            "timezone"  => EnvParser::get('timezone', 'Asia/Shanghai'),
        ],
        "log" => [

            "LineFormatter" => [
                "format"                     => null,
                "dateFormat"                 => null,
                "allowInlineLineBreaks"      => false,
                "ignoreEmptyContextAndExtra" => true,
                "includeStacktraces"         => false,
            ],

            "RotatingFileHandler" => [
                "filename"       => Consts::get('RUNTIME_PATH') . "/log/log.log",
                "maxFiles"       => 0,
                "level"          => Level::Debug,
                "bubble"         => true,
                "filePermission" => null,
                "useLocking"     => false,
                "dateFormat"     => RotatingFileHandler::FILE_PER_DAY,
                "filenameFormat" => '{filename}-{date}',
            ],

            "RedisHandler" => [
                "db_index" => 11,
                "key"      => "slim_logs",
                "level"    => Level::Debug,
                "bubble"   => true,
                "capSize"  => 0,
            ],

            "ErrorLogHandler" => [
                "messageType"    => ErrorLogHandler::OPERATING_SYSTEM,
                "level"          => Level::Debug,
                "bubble"         => true,
                "expandNewlines" => false,
            ],

            "SocketHandler" => [
                "connectionString"  => '',
                "level"             => Level::Debug,
                "bubble"            => true,
                "persistent"        => false,
                "timeout"           => 0,
                "writingTimeout"    => 10,
                "connectionTimeout" => null,
                "chunkSize"         => null,
            ],

            "StreamHandler" => [
                "stream"         => '',
                "level"          => Level::Debug,
                "bubble"         => true,
                "filePermission" => null,
                "useLocking"     => false,
            ],

            "prefix"            => 'cocoApp_log',
            "rotating_file"     => 'rotating.log',
            "rotating_file_max" => 'rotating.log',
        ],
    ];