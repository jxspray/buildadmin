<?php
declare (strict_types = 1);

namespace app\controller;

use app\BaseController;

class Action extends BaseController
{
    public function index()
    {
        var_dump($this->request->action());
        return '您好！这是一个[web]示例应用';
    }

    public function test(){
        return "1231";
    }
}
