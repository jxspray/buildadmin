<?php

namespace app\index\model\web;

use think\Model;
use think\model\concern\SoftDelete;

class Module extends Content
{
//    use SoftDelete;
//    protected $autoWriteTimestamp = 'int';
//
//    protected $createTime = 'createtime';
//    protected $updateTime = 'updatetime';

    protected $name = "cms_module";

    public function getColumnAll(){
        return $this->column("*", 'id');
    }
}
