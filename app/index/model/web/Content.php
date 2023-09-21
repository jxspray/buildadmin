<?php

namespace app\index\model\web;

class Content
{
    public static function getInstance(string $name): object
    {
        return \think\facade\Db::name(\app\index\logics\CmsLogic::PREFIX . $name);
    }
}
