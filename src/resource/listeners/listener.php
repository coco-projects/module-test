<?php

    use Coco\cocoApp\Kernel\Abstracts\CoreEventAbstract;
    use Coco\cocoApp\Kernel\CocoApp;
    use Coco\cocoApp\Kernel\CocoAppConsts;
    use Coco\cocoApp\KernelModule\Listeners\CallableListener;
    use Monolog\Handler\RedisHandler;
    use Monolog\Handler\RotatingFileHandler;

    $app = CocoApp::getInstance();

    return [

        CocoAppConsts::CORE_SYSTEM_INIT_START => [

        ],

        CocoAppConsts::CORE_CONSOLE_INIT_START => [

        ],

        CocoAppConsts::CORE_CONSOLE_INIT_END => [

        ],

        CocoAppConsts::CORE_WEBSITESERVER_INIT_START => [

        ],

        CocoAppConsts::CORE_WEBSITESERVER_INIT_END => [

        ],

        CocoAppConsts::CORE_SYSTEM_INIT_END => [

        ],

        CocoAppConsts::CORE_PROCESS_ON_START => [

        ],

        CocoAppConsts::CORE_PROCESS_RUN_BEFORE => [

        ],

        CocoAppConsts::CORE_PROCESS_RUN => [

        ],

        CocoAppConsts::CORE_PROCESS_RUN_AFTER => [

        ],

        CocoAppConsts::CORE_PROCESS_ON_DONE => [

            new CallableListener(function(CoreEventAbstract $coreEventAbstract) {
                /**
                 * @var CallableListener $this
                 */

                $this->cocoApp->logger->pushHandler($this->cocoApp->getContainer()->get(RotatingFileHandler::class));
                $this->cocoApp->logger->pushHandler($this->cocoApp->getContainer()->get(RedisHandler::class));
                $this->cocoApp->logger->debug($this->cocoApp->request->getUri() . ', 用时:' . $this->cocoApp->timer->totalTime() . 'S' . PHP_EOL);
//                $this->cocoApp->logger->debug($this->cocoApp->route->getPattern().', 用时:' . $this->cocoApp->timer->totalTime() . 'S' . PHP_EOL);

            }, 10000),

        ],

        CocoAppConsts::CORE_PROCESS_ON_CATCH => [

        ],

        CocoAppConsts::CORE_PROCESS_ON_RESULT_IS_TRUE => [

        ],

        CocoAppConsts::CORE_PROCESS_ON_RESULT_IS_FALSE => [

        ],

    ];