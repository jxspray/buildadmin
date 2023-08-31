<?php

namespace app\index\controller\web\home;

use app\admin\model\AdminLog;
use app\index\controller\web\Base;

class Index extends Base
{
    public function index(): string
    {
        AdminLog::where("data->username", 'admin')->find();die;
        $this->settingSEOData();
        return $this->fetch(__FUNCTION__);
    }
}
