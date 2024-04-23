<?php

    use Coco\cocoApp\Kernel\Business\ConsleCommand;
    use Coco\cocoApp\Kernel\Business\ControllerAbstract\ConsoleClosureController;
    use Coco\cocoApp\Kernel\Business\ControllerWrapper\ConsoleControllerWrapper;
    use Coco\cocoApp\Kernel\CocoApp;
    use Coco\moduleTest\Console\Controller\Test;
    use Symfony\Component\Console\Command\Command;

    return function(ConsleCommand $command) {
        /**
         * @var CocoApp $cocoApp
         */
        $cocoApp = CocoApp::getInstance();
        $appName = \Coco\moduleTest\Info::getAppName();

        $command->addRoute('/', ConsoleControllerWrapper::classHandler(Test::class, 'index'),__FILE__,'类测试');

        $command->addRoute('/closureTest', ConsoleControllerWrapper::closure($appName, function(ConsoleControllerWrapper $ins): int {
            /**
             * @var ConsoleClosureController $this
             */

            $input   = $this->input;
            $output  = $this->output;
            $cocoApp = $this->cocoApp;

            $section1 = $output->section();
            $section2 = $output->section();

            $section1->writeln([
                'closureTest111',
            ]);

            $section2->writeln([
                'closureTest222',
            ]);

            return Command::SUCCESS;

        }),__FILE__,'闭包测试');
    };