<?php

    namespace Coco\moduleTest\Http\Controller;

    use Coco\moduleTest\Logic\PeopleArrayLogic;
    use Coco\moduleTest\Logic\PeopleMysqlLogic;
    use Coco\moduleTest\Logic\PeopleXmlLogic;
    use Coco\dataSource\filter\MysqlFilter;
    use Coco\cocoApp\Kernel\Business\ControllerAbstract\WebControllerAbstract;
    use Coco\cocoApp\Kernel\Business\ControllerWrapper\WebControllerWrapper;
    use Slim\Exception\HttpNotFoundException;
    use Psr\Http\Message\ResponseInterface as Response;

    class People extends WebControllerAbstract
    {
        public ?PeopleXmlLogic   $logicXml;
        public ?PeopleMysqlLogic $logicMysql;
        public ?PeopleArrayLogic $logicArray;

        public function __construct(WebControllerWrapper $wrapper)
        {
            $this->logicMysql = PeopleMysqlLogic::getIns();
            $this->logicXml   = PeopleXmlLogic::getIns();
            $this->logicArray = PeopleArrayLogic::getIns();

            parent::__construct($wrapper);
        }

        public function fetchList(): Response
        {
            $request      = $this->cocoApp->request;
            $response     = $this->response;
            $args         = $this->args;
            $routeContext = $this->cocoApp->routeContext;
            $route        = $this->cocoApp->route;
            $cocoApp      = $this->cocoApp;
            $slim         = $this->slimApp;
            // return NotFound for non-existent route

            if (empty($route))
            {
                throw new HttpNotFoundException($request);
            }

            $name      = $route->getName();
            $groups    = $route->getGroups();
            $methods   = $route->getMethods();
            $arguments = $route->getArguments();

            /**
             * ------------------------------------------------------------------------------
             * ------------------------------------------------------------------------------
             */
            $condition = [

                /*
                [
                    'field'     => 'name',
                    'operation' => 'like',
                    'value'     => '%四%',
                    'isEnable'  => 1,
                    'logic'     => 'and',
                ],

                [
                    'field'     => 'name',
                    'operation' => 'like',
                    'value'     => '%王%',
                    'isEnable'  => 1,
                    'logic'     => 'or',
                ],
                 * */
                [
                    'field'     => 'age',
                    'operation' => 'egt',
                    'value'     => 31,
                    'isEnable'  => 1,
                    'logic'     => 'and',

                ],
                /*

                                [
                                    'field'     => 'status',
                                    'operation' => 'status_off',
                                    'value'     => '',
                                    'isEnable'  => 1,
                                    'logic'     => 'and',
                                ],

                                [
                                    'field'     => 'gender',
                                    'operation' => 'not_in',
                                    'value'     => '1,2',
                                    'isEnable'  => 1,
                                    'logic'     => 'or',
                                ],
                                [
                                    'field'     => 'deleted',
                                    'operation' => 'eq',
                                    'value'     => 1,
                                    'isEnable'  => 1,
                                    'logic'     => 'and',
                                ],
                                [
                                    'field'     => 'date',
                                    'operation' => 'gt_date',
                                    'value'     => '2024-03-21',
                                    'isEnable'  => 1,
                                    'logic'     => 'or',
                                ],
                                [
                                    'field'     => 'dateRange',
                                    'operation' => 'between_date',
                                    'value'     => '2024-03-21 - 2024-04-29',
                                    'isEnable'  => 1,
                                    'logic'     => 'and',
                                ],

                                [
                                    'field'     => 'timestamp',
                                    'operation' => 'between_date',
                                    'value'     => '2025-08-20 18:24:41 - 2025-08-20 18:24:43',
                                    'isEnable'  => 1,
                                    'logic'     => 'and',
                                ],
                                [
                                    'field'     => 'timestamp',
                                    'operation' => 'not_eq_date',
                                    'value'     => '2025-08-20 18:24:43',
                                    'isEnable'  => 1,
                                    'logic'     => 'and',
                                ],

                                [
                                    'field'     => 'timeRange',
                                    'operation' => 'between_date',
                                    'value'     => '00:03:03 - 23:56:56',
                                    'isEnable'  => 1,
                                    'logic'     => 'and',
                                ],
                                [
                                    'field'     => 'dateTime',
                                    'operation' => 'eq_date',
                                    'value'     => '2024-03-21 12:22:58',
                                    'isEnable'  => 1,
                                    'logic'     => 'and',
                                ],
                                [
                                    'field'     => 'dateTimeRange',
                                    'operation' => 'between_date',
                                    'value'     => '2024-03-21 00:00:00 - 2024-04-21 23:59:59',
                                    'isEnable'  => 1,
                                    'logic'     => 'and',
                                ],
                                [
                                    'field'     => 'year',
                                    'operation' => 'eq_date',
                                    'value'     => '2024',
                                    'isEnable'  => 1,
                                    'logic'     => 'and',
                                ],
                                [
                                    'field'     => 'yearRange',
                                    'operation' => 'between_date',
                                    'value'     => '2024 - 2025',
                                    'isEnable'  => 1,
                                    'logic'     => 'and',
                                ],
                                [
                                    'field'     => 'month',
                                    'operation' => 'eq_date',
                                    'value'     => '2024-03',
                                    'isEnable'  => 1,
                                    'logic'     => 'and',
                                ],
                                [
                                    'field'     => 'monthRange',
                                    'operation' => 'between_date',
                                    'value'     => '2021-03 - 2024-03',
                                    'isEnable'  => 1,
                                    'logic'     => 'and',
                                ],*/

            ];

            $mysqlFilter = $this->logicMysql->makeFilter($condition);
            $arrayFilter = $this->logicArray->makeFilter($condition);
            $xmlFilter   = $this->logicXml->makeFilter($condition);

//            $this->logicMysql->enabledOnly($mysqlFilter);
//            $this->logicMysql->disabledOnly($mysqlFilter);
//            $this->logicMysql->notDeletedOnly($mysqlFilter);
//            $this->logicMysql->deletedOnly($mysqlFilter);
//            $this->logicMysql->availableOnly($mysqlFilter);

//            $this->logicMysql->orderAsc('id',$mysqlFilter);
            $this->logicMysql->orderDesc('id', $mysqlFilter);

            $sql = $this->logicMysql->source->fetchListSql($mysqlFilter);
            print_r($sql);
            echo PHP_EOL;

            $list = $this->logicMysql->fetchList($mysqlFilter);
//            $list = $this->logicArray->fetchList($arrayFilter);
//            $list = $this->logicXml->fetchList($xmlFilter);

//            $list = $this->logicMysql->fetchColumn('id', $mysqlFilter);
//            $list = $this->logicArray->fetchColumn('id', $arrayFilter);
//            $list = $this->logicXml->fetchColumn('id', $xmlFilter);

            echo PHP_EOL;
            print_r($list);

//            var_export($list);

            return $response;
        }

        public function recycle(): Response
        {
            $request      = $this->cocoApp->request;
            $response     = $this->response;
            $args         = $this->args;
            $routeContext = $this->cocoApp->routeContext;
            $route        = $this->cocoApp->route;
            $cocoApp      = $this->cocoApp;
            $slim         = $this->slimApp;
            // return NotFound for non-existent route

            if (empty($route))
            {
                throw new HttpNotFoundException($request);
            }

            $name      = $route->getName();
            $groups    = $route->getGroups();
            $methods   = $route->getMethods();
            $arguments = $route->getArguments();

            /**
             * ------------------------------------------------------------------------------
             * ------------------------------------------------------------------------------
             */
            $condition   = [
            /*    [
                    'field'     => 'name',
                    'operation' => 'like',
                    'value'     => '%王%',
                    'isEnable'  => 1,
                    'logic'     => 'and',
                ],*/

            ];
            $mysqlFilter = $this->logicMysql->makeFilter($condition);

            $list = $this->logicMysql->recycle($mysqlFilter);
            print_r($list);

            return $response;
        }


        public function fetchItem(): Response
        {
            $request      = $this->cocoApp->request;
            $response     = $this->response;
            $args         = $this->args;
            $routeContext = $this->cocoApp->routeContext;
            $route        = $this->cocoApp->route;
            $cocoApp      = $this->cocoApp;
            $slim         = $this->slimApp;
            // return NotFound for non-existent route

            if (empty($route))
            {
                throw new HttpNotFoundException($request);
            }

            $name      = $route->getName();
            $groups    = $route->getGroups();
            $methods   = $route->getMethods();
            $arguments = $route->getArguments();

            /**
             * ------------------------------------------------------------------------------
             * ------------------------------------------------------------------------------
             */
            $condition   = [
                [
                    'field'     => 'name',
                    'operation' => 'like',
                    'value'     => '%王%',
                    'isEnable'  => 1,
                    'logic'     => 'and',
                ],

            ];
            $mysqlFilter = $this->logicMysql->makeFilter($condition);

            $list = $this->logicMysql->fetchItem($mysqlFilter);
            print_r($list);

            return $response;
        }


        public function fetchItemById(): Response
        {
            $request      = $this->cocoApp->request;
            $response     = $this->response;
            $args         = $this->args;
            $routeContext = $this->cocoApp->routeContext;
            $route        = $this->cocoApp->route;
            $cocoApp      = $this->cocoApp;
            $slim         = $this->slimApp;
            // return NotFound for non-existent route

            if (empty($route))
            {
                throw new HttpNotFoundException($request);
            }

            $name      = $route->getName();
            $groups    = $route->getGroups();
            $methods   = $route->getMethods();
            $arguments = $route->getArguments();

            /**
             * ------------------------------------------------------------------------------
             * ------------------------------------------------------------------------------
             */

            $list = $this->logicMysql->fetchItemById(3);
            print_r($list);

            return $response;
        }


        public function fetchColumn(): Response
        {
            $request      = $this->cocoApp->request;
            $response     = $this->response;
            $args         = $this->args;
            $routeContext = $this->cocoApp->routeContext;
            $route        = $this->cocoApp->route;
            $cocoApp      = $this->cocoApp;
            $slim         = $this->slimApp;
            // return NotFound for non-existent route

            if (empty($route))
            {
                throw new HttpNotFoundException($request);
            }

            $name      = $route->getName();
            $groups    = $route->getGroups();
            $methods   = $route->getMethods();
            $arguments = $route->getArguments();

            /**
             * ------------------------------------------------------------------------------
             * ------------------------------------------------------------------------------
             */

            $list = $this->logicMysql->fetchColumn('id', new MysqlFilter());
            print_r($list);

            return $response;
        }

        public function fetchValue(): Response
        {
            $request      = $this->cocoApp->request;
            $response     = $this->response;
            $args         = $this->args;
            $routeContext = $this->cocoApp->routeContext;
            $route        = $this->cocoApp->route;
            $cocoApp      = $this->cocoApp;
            $slim         = $this->slimApp;
            // return NotFound for non-existent route

            if (empty($route))
            {
                throw new HttpNotFoundException($request);
            }

            $name      = $route->getName();
            $groups    = $route->getGroups();
            $methods   = $route->getMethods();
            $arguments = $route->getArguments();

            /**
             * ------------------------------------------------------------------------------
             * ------------------------------------------------------------------------------
             */
            $condition = [
                [
                    'field'     => 'name',
                    'operation' => 'like',
                    'value'     => '%王%',
                    'isEnable'  => 1,
                    'logic'     => 'and',
                ],
            ];

            $mysqlFilter = $this->logicMysql->makeFilter($condition);
            $mysqlFilter->limit(2);

//            $list = $this->logicMysql->fetchValue('name',$mysqlFilter);
//            $list = $this->logicMysql->totalPages($mysqlFilter);
            $list = $this->logicMysql->count($mysqlFilter);
            print_r($list);

            return $response;
        }


        public function add(): Response
        {
            $request      = $this->cocoApp->request;
            $response     = $this->response;
            $args         = $this->args;
            $routeContext = $this->cocoApp->routeContext;
            $route        = $this->cocoApp->route;
            $cocoApp      = $this->cocoApp;
            $slim         = $this->slimApp;
            // return NotFound for non-existent route

            if (empty($route))
            {
                throw new HttpNotFoundException($request);
            }

            $name      = $route->getName();
            $groups    = $route->getGroups();
            $methods   = $route->getMethods();
            $arguments = $route->getArguments();

            /**
             * ------------------------------------------------------------------------------
             * ------------------------------------------------------------------------------
             */
            $data = [
                'name'      => 'ahkdjfsdl',
                'age'       => 24,
                'hobby'     => '1,3',
                'gender'    => 2,
                'join_time' => time() - 500,
                'order'     => 1000,

            ];

            $list = $this->logicMysql->add($data);
            print_r($list);

            return $response;
        }


        public function addBatch(): Response
        {
            $request      = $this->cocoApp->request;
            $response     = $this->response;
            $args         = $this->args;
            $routeContext = $this->cocoApp->routeContext;
            $route        = $this->cocoApp->route;
            $cocoApp      = $this->cocoApp;
            $slim         = $this->slimApp;
            // return NotFound for non-existent route

            if (empty($route))
            {
                throw new HttpNotFoundException($request);
            }

            $name      = $route->getName();
            $groups    = $route->getGroups();
            $methods   = $route->getMethods();
            $arguments = $route->getArguments();

            /**
             * ------------------------------------------------------------------------------
             * ------------------------------------------------------------------------------
             */
            $data = [
                [
                    'name'      => 'kcs5df64c',
                    'age'       => 24,
                    'hobby'     => '1,3',
                    'gender'    => 2,
                    'join_time' => time() - 500,
                    'order'     => 1000,

                ],

                [
                    'name'      => 'as23df1f1ff',
                    'age'       => 23,
                    'hobby'     => '1,2',
                    'gender'    => 1,
                    'join_time' => time() - 500,
                    'order'     => 1000,
                ],
            ];

            $list = $this->logicMysql->addBatch($data);
            print_r($list);

            return $response;
        }


        public function update(): Response
        {
            $request      = $this->cocoApp->request;
            $response     = $this->response;
            $args         = $this->args;
            $routeContext = $this->cocoApp->routeContext;
            $route        = $this->cocoApp->route;
            $cocoApp      = $this->cocoApp;
            $slim         = $this->slimApp;
            // return NotFound for non-existent route

            if (empty($route))
            {
                throw new HttpNotFoundException($request);
            }

            $name      = $route->getName();
            $groups    = $route->getGroups();
            $methods   = $route->getMethods();
            $arguments = $route->getArguments();

            /**
             * ------------------------------------------------------------------------------
             * ------------------------------------------------------------------------------
             */
            $data = [
                'name'      => 'acacacac',
                'age'       => 23,
                'hobby'     => '1',
                'gender'    => 1,
                'join_time' => time() - 500,
                'order'     => 1000,
            ];

            $condition = [
                [
                    'field'     => 'name',
                    'operation' => 'like',
                    'value'     => '%王%',
                    'isEnable'  => 1,
                    'logic'     => 'and',
                ],
            ];

            $mysqlFilter = $this->logicMysql->makeFilter($condition);

            $list = $this->logicMysql->update($data, $mysqlFilter);
            print_r($list);

            return $response;
        }


        public function delete(): Response
        {
            $request      = $this->cocoApp->request;
            $response     = $this->response;
            $args         = $this->args;
            $routeContext = $this->cocoApp->routeContext;
            $route        = $this->cocoApp->route;
            $cocoApp      = $this->cocoApp;
            $slim         = $this->slimApp;
            // return NotFound for non-existent route

            if (empty($route))
            {
                throw new HttpNotFoundException($request);
            }

            $name      = $route->getName();
            $groups    = $route->getGroups();
            $methods   = $route->getMethods();
            $arguments = $route->getArguments();

            /**
             * ------------------------------------------------------------------------------
             * ------------------------------------------------------------------------------
             */

            $condition = [
                [
                    'field'     => 'name',
                    'operation' => 'like',
                    'value'     => '%ac%',
                    'isEnable'  => 1,
                    'logic'     => 'and',
                ],
            ];

            $mysqlFilter = $this->logicMysql->makeFilter($condition);

            $list = $this->logicMysql->delete($mysqlFilter);
            print_r($list);

            return $response;
        }


        public function updateField(): Response
        {
            $request      = $this->cocoApp->request;
            $response     = $this->response;
            $args         = $this->args;
            $routeContext = $this->cocoApp->routeContext;
            $route        = $this->cocoApp->route;
            $cocoApp      = $this->cocoApp;
            $slim         = $this->slimApp;
            // return NotFound for non-existent route

            if (empty($route))
            {
                throw new HttpNotFoundException($request);
            }

            $name      = $route->getName();
            $groups    = $route->getGroups();
            $methods   = $route->getMethods();
            $arguments = $route->getArguments();

            /**
             * ------------------------------------------------------------------------------
             * ------------------------------------------------------------------------------
             */

            $list = $this->logicMysql->updateField('1,2,3', 'age', 999);
            print_r($list);

            return $response;
        }

        public function updateByIds(): Response
        {
            $request      = $this->cocoApp->request;
            $response     = $this->response;
            $args         = $this->args;
            $routeContext = $this->cocoApp->routeContext;
            $route        = $this->cocoApp->route;
            $cocoApp      = $this->cocoApp;
            $slim         = $this->slimApp;
            // return NotFound for non-existent route

            if (empty($route))
            {
                throw new HttpNotFoundException($request);
            }

            $name      = $route->getName();
            $groups    = $route->getGroups();
            $methods   = $route->getMethods();
            $arguments = $route->getArguments();

            /**
             * ------------------------------------------------------------------------------
             * ------------------------------------------------------------------------------
             */

            $list = $this->logicMysql->updateByIds('1,2,3', [
                "hobby" => "1,2",
                "age"   => 22,
            ]);
            print_r($list);

            return $response;
        }

        public function softDelete(): Response
        {
            $request      = $this->cocoApp->request;
            $response     = $this->response;
            $args         = $this->args;
            $routeContext = $this->cocoApp->routeContext;
            $route        = $this->cocoApp->route;
            $cocoApp      = $this->cocoApp;
            $slim         = $this->slimApp;
            // return NotFound for non-existent route

            if (empty($route))
            {
                throw new HttpNotFoundException($request);
            }

            $name      = $route->getName();
            $groups    = $route->getGroups();
            $methods   = $route->getMethods();
            $arguments = $route->getArguments();

            /**
             * ------------------------------------------------------------------------------
             * ------------------------------------------------------------------------------
             */


            $condition = [
                [
                    'field'     => 'id',
                    'operation' => 'in',
                    'value'     => '3,4,5,6,7',
                    'isEnable'  => 1,
                    'logic'     => 'and',
                ],
            ];

            $mysqlFilter = $this->logicMysql->makeFilter($condition);

//            $list = $this->logicMysql->softDelete($mysqlFilter);
            $list = $this->logicMysql->unsoftDelete($mysqlFilter);
            print_r($list);

            return $response;
        }

        public function statusEnable(): Response
        {
            $request      = $this->cocoApp->request;
            $response     = $this->response;
            $args         = $this->args;
            $routeContext = $this->cocoApp->routeContext;
            $route        = $this->cocoApp->route;
            $cocoApp      = $this->cocoApp;
            $slim         = $this->slimApp;
            // return NotFound for non-existent route

            if (empty($route))
            {
                throw new HttpNotFoundException($request);
            }

            $name      = $route->getName();
            $groups    = $route->getGroups();
            $methods   = $route->getMethods();
            $arguments = $route->getArguments();

            /**
             * ------------------------------------------------------------------------------
             * ------------------------------------------------------------------------------
             */


            $condition = [
                [
                    'field'     => 'id',
                    'operation' => 'in',
                    'value'     => '3,4,5,6,7',
                    'isEnable'  => 1,
                    'logic'     => 'and',
                ],
            ];

            $mysqlFilter = $this->logicMysql->makeFilter($condition);

//            $list = $this->logicMysql->statusEnable($mysqlFilter);
            $list = $this->logicMysql->statusDisable($mysqlFilter);
            print_r($list);

            return $response;
        }


    }