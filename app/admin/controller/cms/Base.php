<?php

namespace app\admin\controller\cms;

use app\common\controller\Backend;
use think\App;

class Base extends Backend
{
    public function initialize()
    {
        parent::initialize();
        static $initState = false;
        if ($initState === false) {
            \app\common\logic\CmsLogic::init();
            $initState = true;
        }
    }
}