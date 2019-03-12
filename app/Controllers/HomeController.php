<?php

namespace App\Controllers;

use App\Models\OrmModel;
use App\Models\UserModel;
use App\Services\ViewServices;

class HomeController
{
    public function index()
    {
        echo "hello world";
    }

    public function user()
    {
        $user = new UserModel();
        $res = $user->first();
        echo json_encode($res, JSON_UNESCAPED_UNICODE);
    }

    public function ormUser(OrmModel $ormModel, $id = 2)
    {
        try {
            $res = $ormModel->findOrFail(1);
            $res['default_id'] = $id;
            echo json_encode($res, JSON_UNESCAPED_UNICODE);
        } catch (\Throwable $e) {
            echo json_encode($e->getMessage());
        }
    }

    public function viewUser()
    {
        $user = new OrmModel();
        try {
            $res = $user->findOrFail(1);
            $view = new ViewServices();
            $view->display("index", ['name' => $res['name']]);
        } catch (\Throwable $throwable) {
            echo json_encode($throwable->getMessage());
        }
    }
}
