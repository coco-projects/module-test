<?php

    namespace Coco\moduleTest\Logic;

    use Coco\moduleTest\Model\PeopleXmlModel;
    use Coco\cocoApp\Kernel\Business\Logic\CocoSourceCollectionLogicAbstract;

    /**
     * @property PeopleXmlModel $model
     */
    class PeopleXmlLogic extends CocoSourceCollectionLogicAbstract
    {
        public function getCallClass(): string
        {
            return __CLASS__;
        }
    }