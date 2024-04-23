<?php

    namespace Coco\moduleTest;

    trait AppName
    {
        public static function getAppName(): string
        {
            return 'moduleTest';
        }
    }