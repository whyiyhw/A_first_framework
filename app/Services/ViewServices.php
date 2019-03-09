<?php
/**
 * Created by PhpStorm.
 * User: 13091
 * Date: 2019/3/9
 * Time: 22:17
 */

namespace App\Services;


class ViewServices
{
    // 视图所在位置
    protected $loader;
    // 模板引擎对象
    protected $twig;

    public function __construct()
    {
        $this->loader = new \Twig\Loader\FilesystemLoader('../app/Views');
        $this->twig = new \Twig\Environment($this->loader, [
            'cache' => '../bootstrap/cache',
        ]);
    }

    /**
     * @param $file_name
     * @param $data
     * @throws \Throwable
     */
    public function display($file_name, $data)
    {
        $file_name = "{$file_name}.html";
        $this->twig->display($file_name, $data);
    }

    public function __destruct()
    {
        unset($this->loader);
        unset($this->twig);
    }
}