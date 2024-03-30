<?php

    use Coco\moduleTest\Http\Controller\People;
    use Coco\cocoApp\CocoApp;
    use Coco\cocoApp\Kernel\Business\ControllerWrapper\WebControllerWrapper;
    use Slim\App;

    return function(App $app) {
        /**
         * @var CocoApp $cocoApp
         */
        $cocoApp = $app->getContainer()->get('cocoApp');

        $app->get('/fetchList', WebControllerWrapper::classHandler(People::class, 'fetchList'));
        $app->get('/fetchItem', WebControllerWrapper::classHandler(People::class, 'fetchItem'));
        $app->get('/fetchItemById', WebControllerWrapper::classHandler(People::class, 'fetchItemById'));
        $app->get('/fetchColumn', WebControllerWrapper::classHandler(People::class, 'fetchColumn'));
        $app->get('/fetchValue', WebControllerWrapper::classHandler(People::class, 'fetchValue'));

        $app->get('/add', WebControllerWrapper::classHandler(People::class, 'add'));
        $app->get('/addBatch', WebControllerWrapper::classHandler(People::class, 'addBatch'));
        $app->get('/update', WebControllerWrapper::classHandler(People::class, 'update'));
        $app->get('/delete', WebControllerWrapper::classHandler(People::class, 'delete'));
        $app->get('/updateField', WebControllerWrapper::classHandler(People::class, 'updateField'));
        $app->get('/updateByIds', WebControllerWrapper::classHandler(People::class, 'updateByIds'));
        $app->get('/softDelete', WebControllerWrapper::classHandler(People::class, 'softDelete'));
        $app->get('/statusEnable', WebControllerWrapper::classHandler(People::class, 'statusEnable'));
        $app->get('/recycle', WebControllerWrapper::classHandler(People::class, 'recycle'));

    };