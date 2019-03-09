<?php
/**
 * Created by PhpStorm.
 * User: 13091
 * Date: 2019/3/9
 * Time: 13:27
 */

namespace App\Models;


class BaseModel
{
    protected $table = "";

    public function __construct()
    {

    }

    public function first()
    {
        //mysql_connect is deprecated
        $mysqli = new \mysqli('localhost', 'root', 'root', 'test');
        if ($mysqli->connect_errno) {
            echo "Failed to connect to Mysql: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error();
        }

        $mysqli->set_charset('utf-8');
        $result = $mysqli->query("SELECT * FROM " . $this->table . " limit 0,1");

        $article = $result->fetch_all(MYSQLI_ASSOC);

        $mysqli->close();
        return $article;
    }
}