<?php

    use Coco\moduleTest\Console\Controller\Test;
    use Coco\cocoApp\CocoApp;
    use Coco\cocoApp\Kernel\Business\ConsleCommand;
    use Coco\cocoApp\Kernel\Business\ControllerAbstract\ConsoleControllerAbstract;
    use Coco\cocoApp\Kernel\Business\ControllerWrapper\ConsoleControllerWrapper;
    use Symfony\Component\Console\Command\Command;

    return function(ConsleCommand $command) {
        /**
         * @var CocoApp $cocoApp
         */
        $cocoApp = CocoApp::getInstance();

        $command->addRoute('/', ConsoleControllerWrapper::classHandler(Test::class, 'index'));

        $command->addRoute('/closureTest', ConsoleControllerWrapper::closure(function(): int {
            /**
             * @var ConsoleControllerAbstract $this
             */

            $input   = $this->input;
            $output  = $this->output;
            $cocoApp = $this->cocoApp;

            $section1 = $output->section();
            $section2 = $output->section();

            $section1->writeln([
                'closureTest',
            ]);

            return Command::SUCCESS;

        }));
    };