<?php

    namespace Coco\moduleTest\Model;

    use Coco\dataSource\source\XmlSource;
    use Coco\cocoApp\Kernel\Business\Model\CocoSourceCollectionModelAbstract;

    /**
     * @property XmlSource $source
     */
    class PeopleXmlModel extends CocoSourceCollectionModelAbstract
    {
        protected function init(): void
        {
            $xmlFilePath  = 'data/test.xml';
            $this->source = XmlSource::getIns(file_get_contents($xmlFilePath), function($data) {
                return $data['item'];
            });

            parent::init();
        }

    }