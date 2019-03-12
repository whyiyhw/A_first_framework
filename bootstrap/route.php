<?php

use Symfony\Component\HttpFoundation\Response;
/**
 * 路由器
 *
 * Class route
 * @package FastRoute
 */
class Router
{
    public $dispatcher;

    /**
     * 路由初始化
     * route constructor.
     * @param FastRoute\Dispatcher $dispatcher
     */
    public function __construct(FastRoute\Dispatcher $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    /**
     * @return Symfony\Component\HttpFoundation\Response
     */
    public function dispatcher()
    {
        // 获取url 与 请求方式
        $httpMethod = $_SERVER['REQUEST_METHOD'];
        $uri = $_SERVER['REQUEST_URI'];

        // 获取问号后面的请求参数 然后转换成 uri
        if (false !== $pos = strpos($uri, '?')) {
            $uri = substr($uri, 0, $pos);
        }
        $uri = rawurldecode($uri);

        // 去匹配处理 参数与 url
        $routeInfo = $this->dispatcher->dispatch($httpMethod, $uri);
        //var_dump($routeInfo);

        switch ($routeInfo[0]) {
            case FastRoute\Dispatcher::NOT_FOUND:
                // ... 404 Not Found
                return new Response("404 Not Found" , 404);
                break;
            case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
//                $allowedMethods = $routeInfo[1];
                // ... 405 Method Not Allowed
                return new Response("request method not found" , 500);
                break;
            case FastRoute\Dispatcher::FOUND:
                $handler = $routeInfo[1];
//                $vars = $routeInfo[2];
                $array = explode("@", $handler);
                $controller = new $array[0];
                $action = $array[1];
                try {
                    return \Ioc::make($controller, $action);
                } catch (\Throwable $e) {
                    return new Response("action error" , 500);
                }
                // ... call $handler with $vars
                break;
        }
        return new Response();
    }
}