<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/3/13 0013
 * Time: 9:46
 */
return [
    'mode' => 'debug', //debug模式 应用程序模式
    'filter' => true, //过滤器开启
    'charSet' => 'utf-8', // 设置网页编码
    'defaultApp' => 'front',// 默认分组
    'defaultController' => 'index',// 默认控制器名称
    'defaultAction' => 'index',// 默认动作名称
    'urlControllerName' => 'c',// 自定义控制器名称
    'urlActionName' => 'a', // 自定义方法名称
    'urlGroupName' => 'g',// 自定义分组名称
    'db' => [
        'dsn' => 'mysql:dbname=test;host=127.0.0.1',
        'username' => 'root',
        'password' => 'root',
        'prefix' => '',
        'param' => []
    ],
    'smtp' => [],
];