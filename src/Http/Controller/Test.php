<?php

    namespace Coco\moduleTest\Http\Controller;

    use Coco\cocoApp\Kernel\Business\ControllerAbstract\WebControllerAbstract;
    use Coco\cocoApp\Kernel\Business\ControllerWrapper\WebControllerWrapper;
    use Slim\Exception\HttpNotFoundException;
    use Psr\Http\Message\ResponseInterface as Response;
    use Coco\downloader\Downloader;
    use Coco\downloader\resource\File;
    use Coco\sse\processor\Psr7Processor;
    use Coco\sse\SSE;
    use Slim\Psr7\NonBufferedBody;
    use Symfony\Component\Cache\CacheItem;

    class Test extends WebControllerAbstract
    {
        public function __construct(WebControllerWrapper $wrapper)
        {
            parent::__construct($wrapper);
        }

        public function index(): Response
        {
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

            $data = $this->cocoApp->cache->get('cocoAppCacheTest', function(CacheItem $item) {
                echo 'by callable';
                echo PHP_EOL;

                return '-----------cocoApp data test----------';
            });


            $response->getBody()->write("Hello index " . $data . PHP_EOL);

            return $response;
        }


        public function params(): Response
        {
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

            $this->respondJson([
                [
                    "name" => $this->resolveArg('name'),
                ],
                $request->getQueryParams(),
            ]);

            return $response;
        }


        public function download(): Response
        {
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

            $file = './data/1.jpg';

            $source = new File($file);
//    $source = new Strings('123456789');

            $nonBufferedBody = new \Slim\Psr7\NonBufferedBody();
            $response        = $response->withBody($nonBufferedBody);
            $processor       = new \Coco\downloader\processor\Psr7Processor($response);

            $d = new Downloader($source, $processor);

            $d->setDownloadName('1.jpg');

            $d->dispositionInline();
//        $d->dispositionAttachment();

//            $d->setLimitRateKB(1024 * 1024 * 10);
//    $d->setBufferSize(1024);

            $d->setOn404Callback(function(\Coco\downloader\processor\Psr7Processor $processor) use ($response) {
                $processor->getResponse()->getBody()->write('File not found');
            });

            $d->setOn416Callback(function(\Coco\downloader\processor\Psr7Processor $processor) {
                $processor->getResponse()->getBody()->write('范围错误');
            });

            $d->send();

            $response = $processor->getResponse();

            return $response;
        }


        public function event(): Response
        {
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

            $response = $response->withBody(new NonBufferedBody());

            $processor = new Psr7Processor($response);

            SSE::init($processor);

            $id = 0;
            while (1)
            {
                $now = date('Y-m-d H:i:s');

                SSE::getEventIns('update')->send(json_encode([
                    "id"   => $id,
                    "data" => $now,
                ]));

                $id++;

                sleep(1);

                if ($id > 100)
                {
                    break;
                }
            }

            return $processor->getResponse();
        }
    }