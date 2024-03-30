<?php

    use Coco\cocoApp\Kernel\Server\ConsoleServer;

    $app    = require './initApp.php';
    $server = new ConsoleServer($app);
    $server->listen();

