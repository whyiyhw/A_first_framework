<?php
/**
 * Created by PhpStorm.
 * User: 13091
 * Date: 2019/3/12
 * Time: 22:22
 */

namespace App\Services;

use Symfony\Component\HttpFoundation\Request;

class RequestService
{

    /**
     * @var  Request
     */
    public $request;

    public function __construct()
    {
        $this->request = Request::createFromGlobals();

        return $this;
    }

    public function get($name, $default)
    {
        return $this->request->query->get($name, $default);
    }
}