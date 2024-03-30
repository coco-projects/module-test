<?php

    use Coco\cocoApp\CocoApp;
    use Coco\cocoApp\CocoAppConsts;
    use Coco\cocoApp\Kernel\Abstracts\CoreEventAbstract;
    use Coco\cocoApp\Kernel\Listeners\CallableListener;
    use Coco\cocoApp\Kernel\Listeners\EchoExceptionMsgListener;
    use Coco\cocoApp\Kernel\Listeners\ThrowExceptionMsgListener;
    use Monolog\Handler\RedisHandler;
    use Monolog\Handler\RotatingFileHandler;

    $app = CocoApp::getInstance();

    return [

        CocoAppConsts::CORE_SYSTEM_INIT_START => [//            new EchoLoggerListener($app),
        ],

        CocoAppConsts::CORE_RUN_LOGIC_START => [//            new EchoLoggerListener($app),
        ],

        CocoAppConsts::CORE_PROCESS_ON_START => [//            new EchoLoggerListener($app),
        ],

        CocoAppConsts::CORE_PROCESS_RUN_BEFORE => [
            new CallableListener($app, function(CoreEventAbstract $coreEventAbstract) {

//                echo $coreEventAbstract->getName();
//                echo PHP_EOL;

            }),
        ],
        CocoAppConsts::CORE_PROCESS_RUN        => [//            new EchoLoggerListener($app),
        ],

        CocoAppConsts::CORE_PROCESS_RUN_AFTER => [
            new CallableListener($app, function(CoreEventAbstract $coreEventAbstract) {

//                echo $coreEventAbstract->getName();
//                echo PHP_EOL;

            }),
        ],

        CocoAppConsts::CORE_PROCESS_ON_DONE => [//            new EchoLoggerListener($app),
        ],

        CocoAppConsts::CORE_PROCESS_ON_CATCH => [
            new EchoExceptionMsgListener($app),
            new ThrowExceptionMsgListener($app),
            //            new EchoLoggerListener($app),
        ],

        CocoAppConsts::CORE_PROCESS_ON_RESULT_IS_TRUE => [//            new EchoLoggerListener($app),
        ],

        CocoAppConsts::CORE_PROCESS_ON_RESULT_IS_FALSE => [//            new EchoLoggerListener($app),
        ],

        CocoAppConsts::CORE_RUN_LOGIC_DONE => [
//            new EchoLoggerListener($app),
new CallableListener($app, function(CoreEventAbstract $coreEventAbstract) {
    /**
     * @var CallableListener $this
     */

    $this->cocoApp->logger->pushHandler($this->cocoApp->getContainer()->get(RotatingFileHandler::class));
    $this->cocoApp->logger->pushHandler($this->cocoApp->getContainer()->get(RedisHandler::class));
    $this->cocoApp->logger->debug($this->cocoApp->request->getUri() . ', 用时:' . $this->cocoApp->timer->totalTime() . 'S' . PHP_EOL);
//                $this->cocoApp->logger->debug($this->cocoApp->route->getPattern().', 用时:' . $this->cocoApp->timer->totalTime() . 'S' . PHP_EOL);
}, 10000),
        ],
    ];