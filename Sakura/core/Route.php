<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/3/13 0013
 * Time: 9:58
 */
class Route
{
    public $group; // 分组名称 或者称为 module
    public $control;// 对应的控制器
    public $action; // 控制器对应的方法
    public $params; // 传给 action 的参数

    public function __construct()
    {

    }

    public function init()
    {
        $route = $this->getRequest();
        $this->group = $route['group'];
        $this->control = $route['control'];
        $this->action = $route['action'];
        // 不用 if 如何 做判定
        !empty($route['param']) && $this->params = $route['params'];
    }

    /**
     * 解析传统url
     * @return array
     */
    public function parseTradition()
    {
        $route = [];
        if (!isset($_GET[$GLOBALS['_config']['UrlGroupName']])) {
            $GLOBALS['_config']['UrlGroupName'] = '';
        }
        if (!isset($_GET[$GLOBALS['_config']['UrlControllerName']])) {
            $GLOBALS['_config']['UrlControllerName'] = '';
        }
        if (!isset($_GET[$GLOBALS['_config']['UrlActionName']])) {
            $GLOBALS['_config']['UrlActionName'] = '';
        }
        $route['group'] = $_GET[$GLOBALS['_config']['UrlGroupName']];
        $route['control'] = $_GET[$GLOBALS['_config']['UrlControllerName']];
        $route['action'] = $_GET[$GLOBALS['_config']['UrlActionName']];

        unset($_GET[$GLOBALS['_config']['UrlGroupName']]);
        unset($_GET[$GLOBALS['_config']['UrlControllerName']]);
        unset($_GET[$GLOBALS['_config']['UrlActionName']]);
        $route = $_GET;
        if ($route['group'] == null) {
            $route['group'] = $GLOBALS['_config']['defaultApp'];
        }
        if ($route['control'] == null) {
            $route['control'] = $GLOBALS['_config']['defaultController'];
        }
        if ($route['action'] == null) {
            $route['action'] = $GLOBALS['_config']['defaultAction'];
        }
        return $route;
    }

    /**
     * 获取这指定的参数
     *
     * @return array
     */
    public function getRequest()
    {
        return $this->parseTradition();
    }
}