<?php

    namespace Coco\moduleTest\Model;

    use Coco\cocoApp\Kernel\Business\Model\CocoSourceMysqlModelAbstract;

    class GenderMysqlModel extends CocoSourceMysqlModelAbstract
    {
        protected function init(): void
        {
            parent::init();

            $this->source->getDbManager()->listen(function($sql, $runtime, $master) {

//                echo "listen:{ $sql }" . PHP_EOL;;
            });
        }

        public function getTableName(): string
        {
            return 'gender';
        }
    }