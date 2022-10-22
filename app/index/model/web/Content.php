<?php

namespace app\index\model\web;

use think\Model;

class Content extends Model
{
    public function __construct($name = '', array $data = [])
    {
        $this->name = $name;
        parent::__construct($data);
    }

    public function getColumnAll() {
        echo 111;
    }
}
