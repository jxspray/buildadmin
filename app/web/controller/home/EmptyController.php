<?php

namespace app\web\controller\home;

use app\index\controller\Action;
use app\web\controller\Base;
use think\App;

class EmptyController extends Action
{
    protected $base;
    public function __construct(App $app)
    {
        parent::__construct($app);
        /* 实例化base */
        $this->base = new Base($app);
    }

    public function _empty() {
    }
}