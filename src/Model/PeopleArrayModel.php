<?php

    namespace Coco\moduleTest\Model;

    use Coco\dataSource\source\IterableSource;
    use Coco\dataSource\source\XmlSource;
    use Coco\cocoApp\Kernel\Business\Model\CocoSourceCollectionModelAbstract;


    /**
     * @property IterableSource $source
     */
    class PeopleArrayModel extends CocoSourceCollectionModelAbstract
    {
        protected function init(): void
        {
            $xmlFilePath  = require 'data/array.php';
            $this->source = IterableSource::getIns($xmlFilePath);

            parent::init();
        }

    }