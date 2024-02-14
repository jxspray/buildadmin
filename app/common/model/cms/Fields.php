<?php

namespace app\index\model\web;

class Fields extends \think\Model implements \app\admin\model\cms\CmsModelInterface
{
    protected $name = "cms_fields";


    public function getColumnAll($param = null): array
    {
        $param['module_id'] = $param['module_id']??1;
        return $this->where('module_id', $param['module_id'])->column("*", 'field');
    }
}