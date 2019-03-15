<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/3/13 0013
 * Time: 9:14
 */
class Sakura
{
    private $route;

    /**
     * @throws Exception
     */
    public function run()
    {
        require_once _SYS_PATH . 'core' . DIRECTORY_SEPARATOR . 'Route.php';
        $this->route();
        $this->dispatch();
    }

    public function route()
    {
        $this->route = new \Route();
        $this->route->init();
    }

    /**
     * @throws Exception
     */
    public function dispatch()
    {
        $controlName = $this->route->control . 'Controller';
        $actionName = $this->route->action . 'Action';
        $path = _APP . $this->route->group . DIRECTORY_SEPARATOR . 'module' . DIRECTORY_SEPARATOR
            . 'controller' . DIRECTORY_SEPARATOR . $controlName . '.php';
        require_once $path;
        $methods = get_class_methods($controlName);
        if (!in_array($actionName, $methods, TRUE)) {
            throw new \Exception(sprintf('方法名%s->%s不存在或者非public', $controlName, $actionName));
        }

        $handler = new $controlName();
        $handler->param = $this->route->param;
        $handler->{$actionName}();
    }
}