<?php

    namespace Coco\moduleTest\Logic;

    use Coco\moduleTest\Model\PeopleArrayModel;
    use Coco\cocoApp\Kernel\Business\Logic\CocoSourceCollectionLogicAbstract;

    /**
     * @property PeopleArrayModel $model
     */
    class PeopleArrayLogic extends CocoSourceCollectionLogicAbstract
    {
        public function getCallClass(): string
        {
            return __CLASS__;
        }
    }