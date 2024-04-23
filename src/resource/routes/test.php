<?php

    use Coco\cocoApp\Kernel\Business\ControllerAbstract\WebControllerAbstract;
    use Coco\cocoApp\Kernel\Business\ControllerWrapper\WebControllerWrapper;
    use Coco\cocoApp\Kernel\CocoApp;
    use Coco\moduleTest\Http\Controller\Test;
    use Psr\Http\Message\ResponseInterface as Response;
    use Slim\App;
    use Slim\Exception\HttpNotFoundException;

    return function(App $app) {
        /**
         * @var CocoApp $cocoApp
         */
        $cocoApp = $app->getContainer()->get('cocoApp');
        $appName = \Coco\moduleTest\Info::getAppName();

        $app->get('/index', WebControllerWrapper::classHandler(Test::class, 'index'));
        $app->get('/cache', WebControllerWrapper::classHandler(Test::class, 'cache'));
        $app->get('/qrcodeRead', WebControllerWrapper::classHandler(Test::class, 'qrcodeRead'));
        $app->get('/qrcodeWrite', WebControllerWrapper::classHandler(Test::class, 'qrcodeWrite'));
        $app->get('/unzip', WebControllerWrapper::classHandler(Test::class, 'unzip'));
        $app->get('/zip', WebControllerWrapper::classHandler(Test::class, 'zip'));

        $app->get('/twig', WebControllerWrapper::classHandler(Test::class, 'twig'));

        $app->get('/sessions', WebControllerWrapper::classHandler(Test::class, 'sessions'));
        $app->get('/params/{name}', WebControllerWrapper::classHandler(Test::class, 'params'));

        $app->get('/event', WebControllerWrapper::classHandler(Test::class, 'event'));
        $app->get('/download', WebControllerWrapper::classHandler(Test::class, 'download'));

        $app->get('/closureTest', WebControllerWrapper::closure($appName, function(): Response {
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

//            https://packagist.org/packages/slim/twig-view
//            https://twig.symfony.com/doc/3.x/

            $data = [
                'name' => 'hello',
            ];

            $this->viewForClosure('closureTest.twig', $data);
//            $this->viewString('name:【{{ name }}】', $data);

//            $response->getBody()->write("【just closureTest】");

            return $response;
        }));


        $app->get('/jsonTest', WebControllerWrapper::closure($appName, function(): Response {
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

//            https://packagist.org/packages/slim/twig-view
//            https://twig.symfony.com/doc/3.x/

            $data = [
                'name' => 'hello',
            ];

            $this->respondJson($data);

            return $response;
        }));



        $app->get('/redirectTest', WebControllerWrapper::closure($appName, function(): Response {
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

//            https://packagist.org/packages/slim/twig-view
//            https://twig.symfony.com/doc/3.x/

            $data = [
                'name' => 'hello',
            ];

//            return $this->redirect('https://www.baidu.com',$data);
            return $this->redirectFor('coco_api_');
        }));


    };