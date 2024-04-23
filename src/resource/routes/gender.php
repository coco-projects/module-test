<?php

    use Coco\cocoApp\Kernel\Business\ControllerWrapper\WebControllerWrapper;
    use Coco\cocoApp\Kernel\CocoApp;
    use Slim\App;

    return function(App $app) {
        /**
         * @var CocoApp $cocoApp
         */
        $cocoApp = $app->getContainer()->get('cocoApp');
        $appName = \Coco\moduleTest\Info::getAppName();

        $app->get('/gender/index', WebControllerWrapper::classHandler(\Coco\moduleTest\Http\Controller\Gender::class, 'index'));

    };