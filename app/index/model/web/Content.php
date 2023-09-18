<?php

namespace app\index\model\web;

use think\Model;

class Content extends Model implements \app\admin\model\cms\CmsModelInterface
{
    public static function getInstance(string $name): static
    {
        $instance = new self();
        $instance->name = \app\index\logics\CmsLogic::PREFIX . $name;
        return $instance;
    }

    public function getColumnAll($param = null): array
    {
        return $this->column("*", 'id');
    }
}
