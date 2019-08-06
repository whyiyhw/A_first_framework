<?php

namespace App\Controllers;

use App\Models\OrmModel;
use App\Models\UserModel;
use App\Services\RequestService;
use App\Services\ResponseService;
use App\Services\ViewServices;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class HomeController
{

    /**
     * 引入 了 Sy的组件 并对其 做出封装
     *
     * @param RequestService $request
     * @param ResponseService $response
     * @return Response
     */
    /**
     * @param RequestService $request
     * @param ResponseService $response
     * @return Response
     * @throws Throwable
     */
    public function index(RequestService $request, ResponseService $response)
    {
        $view = new ViewServices();
        $view->display("index",[]);
        return $response->show();
//        $name = $request->get("name", "world");
//
//        return $response->echo("hello {$name}");
    }

    /**
     * 返回第一个获取的 值
     *
     * @param ResponseService $response
     * @return JsonResponse
     */
    public function user(ResponseService $response)
    {
        $user = new UserModel();
        $res = $user->first();
        return $response->json($res);
    }

    /**
     * 使用 think-orm 进行数据库操作
     *
     * @param OrmModel $ormModel
     * @param ResponseService $response
     * @param int $id
     * @return JsonResponse
     */
    public function ormUser(OrmModel $ormModel, ResponseService $response, $id = 2)
    {
        try {
            $res = $ormModel->findOrFail(1);
            $res['default_id'] = $id;
            return $response->json($res);
        } catch (Throwable $e) {
            return $response->json([$e->getMessage()]);
        }
    }

    /**
     * 返回一个视图
     * @param ResponseService $response
     * @return Response
     * @throws Throwable
     */
    public function viewUser(ResponseService $response)
    {
        $user = new OrmModel();
        $res = $user->findOrFail(1);
        $view = new ViewServices();
        $view->display("index", ['name' => $res['name']]);
        return $response->show();
    }
}
