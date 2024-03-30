<?php

    namespace Coco\moduleTest\Services;

    use Coco\cocoApp\Kernel\Abstracts\ServiceProviderAbstract;
    use DI\Container;
    use Slim\Csrf\Guard;

    class CsrfProvider extends ServiceProviderAbstract
    {
        public static string $name = 'csrf';

        public function register(Container $container): void
        {
            $container->set(static::$name, function(Container $container) {
                if (session_status() !== PHP_SESSION_ACTIVE)
                {
                    session_start();
                }

                return new Guard($container->get('router'));
            });
        }
    }