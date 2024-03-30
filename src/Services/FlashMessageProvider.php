<?php

    namespace Coco\moduleTest\Services;

    use Coco\cocoApp\Kernel\Abstracts\ServiceProviderAbstract;
    use DI\Container;

    class FlashMessageProvider extends ServiceProviderAbstract
    {
        public static string $name = 'flash';

        public function register(Container $container): void
        {
            $container->set(static::$name, function(Container $container) {
                return new \Slim\Flash\Messages();
            });
        }
    }