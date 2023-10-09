<?php

namespace app\index\model\web;

use think\Model;

class Content extends Model
{
    public static function getInstance(string $name): object
    {
//        $instancs = new self();
//        var_dump($instancs->table(\app\index\logics\CmsLogic::PREFIX . $name)->select);die;
//        $instancs->table(\app\index\logics\CmsLogic::PREFIX . $name);
//        return $instancs;
        return \think\facade\Db::name(\app\index\logics\CmsLogic::PREFIX . $name);
    }
}
