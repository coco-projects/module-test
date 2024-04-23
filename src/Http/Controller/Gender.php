<?php

    namespace Coco\moduleTest\Http\Controller;

    use Coco\moduleTest\Logic\GenderMysqlLogic;
    use Coco\cocoApp\Kernel\Business\ControllerWrapper\WebControllerWrapper;
    use Slim\Exception\HttpNotFoundException;
    use Psr\Http\Message\ResponseInterface as Response;

    class Gender extends BaseController
    {
        public ?GenderMysqlLogic $logicMysql;

        public function __construct(WebControllerWrapper $wrapper)
        {
            $this->logicMysql = GenderMysqlLogic::getIns();

            parent::__construct($wrapper);
        }

        public function index(): Response
        {
            $request      = $this->cocoApp->request;
            $response     = $this->response;
            $args         = $this->args;
            $routeContext = $this->cocoApp->routeContext;
            $route        = $this->cocoApp->route;
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

            /**
             * ------------------------------------------------------------------------------
             * ------------------------------------------------------------------------------
             */
            $response->getBody()->write("Hello index" . PHP_EOL);

            return $response;
        }
    }