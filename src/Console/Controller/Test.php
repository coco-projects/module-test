<?php

    namespace Coco\moduleTest\Console\Controller;

    use Coco\cocoApp\Kernel\Business\ControllerAbstract\ConsoleControllerAbstract;
    use Coco\cocoApp\Kernel\Business\ControllerWrapper\ConsoleControllerWrapper;
    use Symfony\Component\Console\Command\Command;

    class Test extends ConsoleControllerAbstract
    {
        public function __construct(ConsoleControllerWrapper $wrapper)
        {
            parent::__construct($wrapper);
        }

        public function index(): int
        {
            $input   = $this->input;
            $output  = $this->output;
            $cocoApp = $this->cocoApp;

            $section1 = $output->section();
            $section2 = $output->section();

            $section1->writeln([
                'Hello22222222222222',
            ]);

            return Command::SUCCESS;
        }


    }