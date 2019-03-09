<?php
// 我们需要一个 容器 做一个 注册树模式

// 注册一个良好的错误提示工具
$whoops = new \Whoops\Run;
$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
$whoops->register();

// 加载配置文件
$config = require_once __DIR__ . '/../config/database.php';

// 初始化数据库 ORM 链接
\think\Db::setConfig($config);

// 加载定义路由
return require_once __DIR__ . "/../route/web.php";