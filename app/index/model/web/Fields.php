<?php

namespace app\index\model\web;

class Fields extends \think\Model implements \app\admin\model\cms\CmsModelInterface
{
    protected $name = "cms_field";


    public function getColumnAll($param = null): array
    {
        $param['moduleid'] = $param['moduleid']??1;
        return $this->where('moduleid', $param['moduleid'])->column("*", 'field');
    }
}