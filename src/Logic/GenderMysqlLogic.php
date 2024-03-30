<?php

    namespace Coco\moduleTest\Logic;

    use Coco\moduleTest\Model\GenderMysqlModel;
    use Coco\cocoApp\Kernel\Business\Logic\CocoSourceMysqlLogicAbstract;

    /**
     * @property GenderMysqlModel $model
     */
    class GenderMysqlLogic extends CocoSourceMysqlLogicAbstract
    {
        public function getCallClass(): string
        {
            return __CLASS__;
        }
    }