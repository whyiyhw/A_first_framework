<?php
namespace FastRoute;

/**
 * 返回一个注册了路由的对象，最终由这个对象去实现路由匹配
 *
 * @return Dispatcher
 */
return simpleDispatcher(function(RouteCollector $r) {
    // fast-router test
    $r->addRoute('GET', '/', "App\Controllers\HomeController@index");
    $r->addRoute('GET', '/user', "App\Controllers\HomeController@user");
    $r->addRoute('GET', '/orm-user', "App\Controllers\HomeController@ormUser");
    $r->addRoute('GET', '/view-user', "App\Controllers\HomeController@viewUser");
});