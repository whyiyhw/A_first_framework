<?php
/**
 * Created by PhpStorm.
 * User: 13091
 * Date: 2019/3/12
 * Time: 22:26
 */
namespace App\Services;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
class ResponseService
{

    /**
     * @var  Response
     */
    public $response;

    public function __construct()
    {
        $this->response = new Response();

        return $this;
    }

    /**
     * 用于一般情况下的输出
     *
     * @param string $content
     * @return Response
     */
    public function echo($content = '')
    {
        return $this->response->setContent($content);
    }

    /**
     * 用于 json 格式的输出
     * @param $arr
     * @return JsonResponse
     */
    public function json($arr)
    {
        $response = new JsonResponse();
       return $response->setData($arr);
    }
}