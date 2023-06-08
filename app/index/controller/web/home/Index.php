<?php

namespace app\index\controller\web\home;

use app\index\controller\web\Base;

class Index extends Base
{
    public function index(){
        return $this->fetch(__FUNCTION__);
    }
}
