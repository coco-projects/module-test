<?php

    use Coco\cocoApp\CocoApp;
    use Coco\cocoApp\Kernel\Business\ControllerWrapper\WebControllerWrapper;
    use Slim\App;

    return function(App $app) {
        /**
         * @var CocoApp $cocoApp
         */
        $cocoApp = $app->getContainer()->get('cocoApp');

        $app->get('/gender/index', WebControllerWrapper::classHandler(\Coco\moduleTest\Http\Controller\Gender::class, 'index'));

    };