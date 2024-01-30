<?php

namespace app\index\model\web\contents;

class Page extends \think\Model implements \app\admin\model\cms\CmsModelInterface
{
    protected $name = "cms_page";

    public function getColumnAll($param = null): array
    {
        return $this->column("*", 'id');
    }
}