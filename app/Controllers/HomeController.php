<?php

namespace App\Controllers;

use App\Models\OrmModel;
use App\Models\UserModel;
use App\Services\RequestService;
use App\Services\ResponseService;
use App\Services\ViewServices;

class HomeController
{

    /**
     * 引入 了 Sy的组件 并对其 做出封装
     *
     * @param RequestService $requestService
     * @param ResponseService $response
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(RequestService $requestService, ResponseService $response)
    {
        $name = $requestService->get("name", "world");

        return $response->echo("hello {$name}");
    }

    /**
     * 返回第一个获取的 值
     *
     * @param ResponseService $responseService
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function user(ResponseService $responseService)
    {
        $user = new UserModel();
        $res = $user->first();
        return $responseService->json($res);
    }

    /**
     * 使用 think-orm 进行数据库操作
     *
     * @param OrmModel $ormModel
     * @param ResponseService $responseService
     * @param int $id
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function ormUser(OrmModel $ormModel,ResponseService $responseService, $id = 2)
    {
        try {
            $res = $ormModel->findOrFail(1);
            $res['default_id'] = $id;
            return $responseService->json($res);
        } catch (\Throwable $e) {
            return $responseService->json([$e->getMessage()]);
        }
    }

    /**
     * 返回一个视图 或者 json 对象
     *
     * @param ResponseService $responseService
     * @return \Symfony\Component\HttpFoundation\JsonResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function viewUser(ResponseService $responseService)
    {
        $user = new OrmModel();
        try {
            $res = $user->findOrFail(1);
            $view = new ViewServices();
            $view->display("index", ['name' => $res['name']]);
            return $responseService->echo();
        } catch (\Throwable $e) {
            return $responseService->json([$e->getMessage()]);
        }
    }
}
