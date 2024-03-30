<?php

    use Slim\App;
    use Slim\Middleware\ContentLengthMiddleware;
    use Middlewares\TrailingSlash;
    use Psr\Http\Message\RequestInterface as Request;
    use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
    use Slim\Psr7\Response;

    use Psr\Http\Server\RequestHandlerInterface;
    use Slim\Factory\AppFactory;
    use Slim\Routing\RouteCollectorProxy;
    use Slim\Routing\RouteContext;


    return function(App $app) {


        $app->addBodyParsingMiddleware();

//        $app->add(new ContentLengthMiddleware());

        $app->addRoutingMiddleware();

        $app->add(new TrailingSlash(false));

        $app->add(new Middlewares\Firewall([
//            '192.168.0.111',
        ]));

/*
        $app->add(function(Request $request, RequestHandler $handler) {
            $uri  = $request->getUri();
            $path = $uri->getPath();

            $routeContext = RouteContext::fromRequest($request);
            $route        = $routeContext->getRoute();

            // return NotFound for non-existent route
            if (empty($route))
            {
                throw new HttpNotFoundException($request);
            }

            $name      = $route->getName();
            $groups    = $route->getGroups();
            $methods   = $route->getMethods();
            $arguments = $route->getArguments();

            if ($path != '/' && substr($path, -1) == '/')
            {
                // recursively remove slashes when its more than 1 slash
                $path = rtrim($path, '/');

                // permanently redirect paths with a trailing slash
                // to their non-trailing counterpart
                $uri = $uri->withPath($path);

                if ($request->getMethod() == 'GET')
                {
                    $response = new Response();

                    return $response->withHeader('Location', (string)$uri)->withStatus(301);
                }
                else
                {
                    $request = $request->withUri($uri);
                }
            }

            return $handler->handle($request);
        });*/

        /*
         *
            $app->add(function(Request $request, RequestHandlerInterface $handler): Response {
                $routeContext   = RouteContext::fromRequest($request);
                $routingResults = $routeContext->getRoutingResults();
                $methods        = $routingResults->getAllowedMethods();
                $requestHeaders = $request->getHeaderLine('Access-Control-Request-Headers');

                $response = $handler->handle($request);

                $response = $response->withHeader('Access-Control-Allow-Origin', '*');
                $response = $response->withHeader('Access-Control-Allow-Methods', implode(',', $methods));
                $response = $response->withHeader('Access-Control-Allow-Headers', $requestHeaders);

                // Optional: Allow Ajax CORS requests with Authorization header
                // $response = $response->withHeader('Access-Control-Allow-Credentials', 'true');

                return $response;
            });

            */

        /**
         * ------------------------------------------------
         * 最后一个
         * ------------------------------------------------
         */
        $app->add(new Zeuxisoo\Whoops\Slim\WhoopsMiddleware([
            'enable' => true,
            'editor' => 'phpstorm',
            'title'  => 'slim project',
        ]));

//        $app->addErrorMiddleware(true, true, true);

    };
