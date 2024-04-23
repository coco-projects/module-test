<?php

    namespace Coco\moduleTest;

    use Coco\cocoApp\Kernel\Abstracts\AppInfoAbstract;

    class Info extends AppInfoAbstract
    {
        use AppName;

        public function getAppBasePath(): string
        {
            return __DIR__;
        }
    }