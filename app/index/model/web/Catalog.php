<?php

namespace app\index\model\web;

use think\Model;
use think\model\concern\SoftDelete;

class Catalog extends Content implements \app\admin\model\cms\CmsModelInterface
{
//    use SoftDelete;
//    protected $autoWriteTimestamp = 'int';
//
//    protected $createTime = 'createtime';
//    protected $updateTime = 'updatetime';

    protected $name = "cms_catalog";

    public function getColumnAll($param = null): array
    {
        return $this->column("*", 'id');
    }
}
