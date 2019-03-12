<?php
// 引入自动加载
require_once __DIR__ . '/../vendor/autoload.php';

// 启动器
$route = require_once __DIR__ . '/../bootstrap/app.php';

// ioc 注入
require_once __DIR__ . '/../bootstrap/ioc.php';

// 加载路由器
require_once __DIR__ . "/../bootstrap/route.php";

// 启动路由分配
(new \Router($route))->dispatcher();