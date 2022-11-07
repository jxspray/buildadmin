<?php

namespace app\index\model\web;

use think\Model;

class Content extends Model implements \app\admin\model\cms\CmsModelInterface
{
    public function __construct($name = '', array $data = [])
    {
        if (!empty($name)) $this->name = $name;
        parent::__construct($data);
    }

    public function getColumnAll(): array
    {
        return $this->column("*", 'id');
    }
}
