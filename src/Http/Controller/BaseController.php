<?php

    namespace Coco\moduleTest\Http\Controller;

    use Coco\cocoApp\Kernel\Business\ControllerAbstract\WebControllerAbstract;

    class BaseController extends WebControllerAbstract
    {
        use \Coco\moduleTest\AppName;
    }