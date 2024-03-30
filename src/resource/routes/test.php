<?php

    use Coco\moduleTest\Http\Controller\People;
    use Coco\moduleTest\Http\Controller\Test;
    use Coco\cocoApp\CocoApp;
    use Coco\cocoApp\Kernel\Business\ControllerAbstract\WebControllerAbstract;
    use Coco\cocoApp\Kernel\Business\ControllerWrapper\WebControllerWrapper;
    use Slim\App;
    use Psr\Http\Message\ResponseInterface as Response;
    use Psr\Http\Message\ServerRequestInterface as Request;
    use Slim\Exception\HttpNotFoundException;

    return function(App $app) {
        /**
         * @var CocoApp $cocoApp
         */
        $cocoApp = $app->getContainer()->get('cocoApp');

        $app->get('/', WebControllerWrapper::classHandler(Test::class, 'index'));
        $app->get('/params/{name}', WebControllerWrapper::classHandler(Test::class, 'params'));

        $app->get('/event', WebControllerWrapper::classHandler(Test::class, 'event'));
        $app->get('/download', WebControllerWrapper::classHandler(Test::class, 'download'));

        $app->get('/closureTest', WebControllerWrapper::closure(function(): Response {
            /**
             * @var WebControllerAbstract $this
             */

            $request      = $this->request;
            $response     = $this->response;
            $args         = $this->args;
            $routeContext = $this->routeContext;
            $route        = $this->route;
            $cocoApp      = $this->cocoApp;
            $slim         = $this->slimApp;

            // return NotFound for non-existent route
            if (empty($route))
            {
                throw new HttpNotFoundException($request);
            }

            $name      = $route->getName();
            $groups    = $route->getGroups();
            $methods   = $route->getMethods();
            $arguments = $route->getArguments();

            $this->cocoApp->cache->delete('cocoAppCacheTest');

            $response->getBody()->write("【just closureTest】");

            return $response;
        }));
    };