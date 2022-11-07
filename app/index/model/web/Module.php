<?php

namespace app\index\model\web;

use think\Model;
use think\model\concern\SoftDelete;

class Module extends Content implements \app\admin\model\cms\CmsModelInterface
{
//    use SoftDelete;
//    protected $autoWriteTimestamp = 'int';
//
//    protected $createTime = 'createtime';
//    protected $updateTime = 'updatetime';

    protected $name = "cms_module";

    public function getColumnAll(): array
    {
        return $this->column("*", 'id');
    }
}
