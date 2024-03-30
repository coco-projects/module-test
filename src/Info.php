<?php

    namespace Coco\moduleTest;

    use Coco\cocoApp\Kernel\Abstracts\AppInfoAbstract;

    class Info extends AppInfoAbstract
    {
        public string $appName = 'admin';

        public function getAppBasePath(): string
        {
            return __DIR__;
        }
    }