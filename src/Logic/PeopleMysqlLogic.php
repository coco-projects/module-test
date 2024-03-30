<?php

    namespace Coco\moduleTest\Logic;

    use Coco\moduleTest\Model\PeopleMysqlModel;
    use Coco\cocoApp\Kernel\Business\Logic\CocoSourceMysqlLogicAbstract;
    use Coco\processManager\CallableLogic;
    use Coco\processManager\ProcessRegistry;

    /**
     * @property PeopleMysqlModel $model
     */
    class PeopleMysqlLogic extends CocoSourceMysqlLogicAbstract
    {
        public function getCallClass(): string
        {
            return __CLASS__;
        }

        protected function init(): void
        {
            parent::init();

            //添加额外逻辑
            $this->initRule = [
                $this->method_fetch_item => function(ProcessRegistry $registry) {
                    $method = $this->method_fetch_item;

                    //设置关联表
                    $registry->filter->field('a.id people_id,name,b.gender_name');
                    $registry->filter->alias('a')->join(['gender' => 'b'], 'a.gender=b.id');

                    //设置字段转换
                    $map = [
                        "1" => ["label" => "男",],
                        "2" => ["label" => "女",],
                        "3" => ["label" => "未知",],
                    ];

                    $map = GenderMysqlLogic::getIns()->source->toMap('id', 'gender_name');

                    $this->source->coverFieldFormMap('gender', $map);

                    $registry->setOnStart(CallableLogic::getIns(function(ProcessRegistry $registry, CallableLogic $logic) {
                        $logic->setDebugMsg('setOnStart-debugMsg');
                        $logic->setMsg('setOnStart-msg');
                        echo 'logicName : ' . $logic->getName();

                        echo PHP_EOL;

                        //return false;
                    }, $method . ':OnStart'));

                    $registry->setOnDone(CallableLogic::getIns(function(ProcessRegistry $registry, CallableLogic $logic) {
                        $logic->setDebugMsg('setOnDone-debugMsg');
                        $logic->setMsg('setOnDone-msg');
                        echo 'logicName : ' . $logic->getName();
                        echo PHP_EOL;

                        //return false;
                    }, $method . ':OnDone'));

                    $registry->setOnCatch(CallableLogic::getIns(function(ProcessRegistry $registry, CallableLogic $logic) {
                        $logic->setDebugMsg('setOnCatch-debugMsg');
                        $logic->setMsg('setOnCatch-msg');
                        echo 'logicName : ' . $logic->getName();
                        echo PHP_EOL;

                        //return false;
                    }, $method . ':OnCatch'));

                    $registry->setOnResultIsTrue(CallableLogic::getIns(function(ProcessRegistry $registry, CallableLogic $logic) {
                        $logic->setDebugMsg('setOnResultIsTrue-debugMsg');
                        $logic->setMsg('setOnResultIsTrue-msg');
                        echo 'logicName : ' . $logic->getName();
                        echo PHP_EOL;

                        //return false;
                    }, $method . ':OnResultIsTrue'));

                    $registry->setOnResultIsFalse(CallableLogic::getIns(function(ProcessRegistry $registry, CallableLogic $logic) {
                        $logic->setDebugMsg('setOnResultIsFalse-debugMsg');
                        $logic->setMsg('setOnResultIsFalse-msg');
                        echo 'logicName : ' . $logic->getName();
                        echo PHP_EOL;

                        //return false;
                    }, $method . ':OnResultIsFalse'));

                    $registry->injectLogicBatchBefore([
                        CallableLogic::getIns(function(ProcessRegistry $registry, CallableLogic $logic) {
                            $logic->setDebugMsg('apendLogic_1_before-debugMsg');
                            $logic->setMsg('apendLogic_1_before-msg');
                            echo 'logicName : apendLogic_1_before : ' . $logic->getName();
                            echo PHP_EOL;

                            //return false;
                        }),

                        CallableLogic::getIns(function(ProcessRegistry $registry, CallableLogic $logic) {
                            $logic->setDebugMsg('apendLogic_2_before-debugMsg');
                            $logic->setMsg('apendLogic_2_before-msg');
                            echo 'logicName : apendLogic_2_before : ' . $logic->getName();
                            echo PHP_EOL;

                            //return false;
                        }),

                    ], $method);

                    $registry->injectLogicBatchAfter([
                        CallableLogic::getIns(function(ProcessRegistry $registry, CallableLogic $logic) {
                            $logic->setDebugMsg('apendLogic_1_after-debugMsg');
                            $logic->setMsg('apendLogic_1_after-msg');
                            echo 'logicName : apendLogic_1_after : ' . $logic->getName();
                            echo PHP_EOL;

                            //return false;
                        }),
                        CallableLogic::getIns(function(ProcessRegistry $registry, CallableLogic $logic) {
                            $logic->setDebugMsg('apendLogic_2_after-debugMsg');
                            $logic->setMsg('apendLogic_2_after-msg');
                            echo 'logicName : apendLogic_2_after : ' . $logic->getName();
                            echo PHP_EOL;

                            //return false;
                        }),
                    ], $method);

                    $registry->injectLogicBatchTop([
                        CallableLogic::getIns(function(ProcessRegistry $registry, CallableLogic $logic) {
                            $logic->setDebugMsg('topLogic_1-debugMsg');
                            $logic->setMsg('topLogic_1-msg');
                            echo 'logicName : topLogic_1 : ' . $logic->getName();
                            echo PHP_EOL;

                            //return false;
                        }),

                        CallableLogic::getIns(function(ProcessRegistry $registry, CallableLogic $logic) {
                            $logic->setDebugMsg('topLogic_2-debugMsg');
                            $logic->setMsg('topLogic_2-msg');
                            echo 'logicName : topLogic_2 : ' . $logic->getName();
                            echo PHP_EOL;

                            //return false;
                        }),

                    ]);

                    $registry->injectLogicBatchEnd([
                        CallableLogic::getIns(function(ProcessRegistry $registry, CallableLogic $logic) {
                            $logic->setDebugMsg('endLogic_1-debugMsg');
                            $logic->setMsg('endLogic_1-msg');
                            echo 'logicName : endLogic_1 : ' . $logic->getName();
                            echo PHP_EOL;

                            //return false;
                        }),

                        CallableLogic::getIns(function(ProcessRegistry $registry, CallableLogic $logic) {
                            $logic->setDebugMsg('endLogic_2-debugMsg');
                            $logic->setMsg('endLogic_2-msg');
                            echo 'logicName : endLogic_2 : ' . $logic->getName();
                            echo PHP_EOL;

                            //return false;
                        }),

                    ]);

                    $registry->prependLogic(CallableLogic::getIns(function(ProcessRegistry $registry, CallableLogic $logic) {
                        $logic->setDebugMsg('prependLogic_1-debugMsg');
                        $logic->setMsg('prependLogic_1-msg');
                        echo 'logicName : ' . $logic->getName();
                        echo PHP_EOL;

                        //return false;
                    }, 'prependLogic_1'));

                    $registry->prependLogic(CallableLogic::getIns(function(ProcessRegistry $registry, CallableLogic $logic) {
                        $logic->setDebugMsg('prependLogic_2-debugMsg');
                        $logic->setMsg('prependLogic_2-msg');
                        echo 'logicName : ' . $logic->getName();
                        echo PHP_EOL;

                        //return false;
                    }, 'prependLogic_2'));
                },
            ];
        }

    }