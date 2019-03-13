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
        // 不用 if 写判定
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
        return $this->getPathInfo();
    }

    /**
     * 解析pathInfo 模式
     * @return array
     */
    public function getPathInfo()
    {
        $filter_param = ['<', '>', '"', "'", "%3C", '%3E', '%22', '%27', "%3c", "%3e"];
        $uri = str_replace($filter_param, '', $_SERVER['REQUEST_URI']);
        $path = parse_url($uri);
        if (strpos($path['path'], 'index.php' == 0)) {
            $url_base = $path['path'];
        } else {
            $url_base = substr($path['path'], strlen('index.php') + 1);
        }
        // 去除左边的 '/'
        $url_base = ltrim($url_base, '/');
        if ($url_base == '') {
            return $this->parseTradition();
        }
        // 获取一个参数数组
        $reqArray = explode('/', $url_base);
        foreach ($reqArray as $k => $v) {
            if (empty($v)) {
                unset($reqArray[$k]);
            }
        }
        // 统计还剩几个参数
        $count = count($reqArray);
        if (empty($reqArray) || empty($reqArray[0])) {
            $count = 0;
        }

        switch ($count) {
            case 0;
                $route['group'] = $GLOBALS['_config']['defaultApp'];
                $route['control'] = $GLOBALS['_config']['defaultController'];
                $route['action'] = $GLOBALS['_config']['defaultAction'];
                break;
            case 1;
                if (strpos($reqArray[0], ':')) {
                    $gc = explode(':', $reqArray[0]);
                    $route['group'] = $gc[0];
                    $route['control'] = $gc[1];
                    $route['action'] = $GLOBALS['_config']['defaultAction'];
                } else {
                    $route['group'] = $GLOBALS['_config']['defaultApp'];
                    $route['control'] = $reqArray[0];
                    $route['action'] = $GLOBALS['_config']['defaultAction'];
                }
                break;
            default:
                if (strpos($reqArray[0], ':')) {
                    $gc = explode(':', $reqArray[0]);
                    $route['group'] = $gc[0];
                    $route['control'] = $gc[1];
                    $route['action'] = $reqArray[1];
                } else {
                    $route['group'] = $GLOBALS['_config']['defaultApp'];
                    $route['control'] = $reqArray[0];
                    $route['action'] = $reqArray[1];
                }
                // 结构 为 /c/a/id/1 所以可以这么玩 或者 /g:c/a/id/1
                for ($i = 2; $i < $count; $i++) {
                    $route['param'][$reqArray[$i]] = isset($reqArray[++$i]) ? $reqArray[$i] : '';
                }
        }
        return $route;
    }
}