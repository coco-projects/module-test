<?php

    use Coco\cocoApp\Kernel\Server\WebSiteServer;

    $app    = require '../initApp.php';
    $server = new WebSiteServer($app);

    $server->listen();

