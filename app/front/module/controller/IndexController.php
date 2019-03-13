<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/3/13 0013
 * Time: 9:19
 */
class IndexController
{
    public function indexAction()
    {
        require_once _SYS_PATH.'core'.DIRECTORY_SEPARATOR.'Db.php';
        try{
            $db = Db::getInstance($GLOBALS['_config']['db']);
            $ret = $db->query('select * from `user` where id > :id',['id' => 1]);
            var_dump($ret);
        }catch (\Throwable $e){
            echo $e->getMessage();
        }
        echo "hello world";
    }
}