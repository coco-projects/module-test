<?php

    namespace Coco\moduleTest\Validate;

    use Coco\validate\Validate;

    class PeopleMysqlValidate extends Validate
    {
        protected array $rule = [
            Validate::SCENE_ADD => [

                "name"  => [
                    "require"          => "姓名必须填写",
                    "lengthRange:6,12" => "姓名6-12位",
                ],
                "age"   => [
                    "number"         => "必须是数字",
                    ">:12"           => "必须大于12",
                    "notIn:21,31,41" => "不能是21,31,41",
                    "between:15,25"  => "年龄必须在15-25之间",
                ],
                "hobby" => [
                    "require"              => "爱好必须填写",
                    'regex:#^\d+(,\d+)+$#' => '格式不对',
                ],

                "gender" => [
                    "require" => "gender 必须填写",
                ],

            ],
            Validate::SCENE_EDIT => [

                "name"  => [
                    "require"          => "姓名必须填写",
                    "lengthRange:6,12" => "姓名6-12位",
                ],
                "age"   => [
                    "number"         => "必须是数字",
                    ">:12"           => "必须大于12",
                    "notIn:21,31,41" => "不能是21,31,41",
                    "between:15,25"  => "年龄必须在15-25之间",
                ],
                "hobby" => [
                    "require"              => "爱好必须填写",
                    'regex:#^\d+(,\d+)*$#' => '格式不对',
                ],

                "gender" => [
                    "require" => "gender 必须填写",
                ],

            ],
        ];


    }