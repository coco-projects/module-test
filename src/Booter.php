<?php

    namespace Coco\moduleTest;

    use Coco\cocoApp\Kernel\Abstracts\BooterAbstract;

    class Booter extends BooterAbstract
    {
        public function __construct()
        {
            $this->appInfo = new Info();
        }
    }