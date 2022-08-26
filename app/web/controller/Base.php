<?php
declare (strict_types = 1);

namespace app\web\controller;

use app\index\controller\Action;
use think\App;

class Base extends Action
{
    protected $terminal;
    
    public function __construct(App $app)
    {
        parent::__construct($app);
        // 设置终端
        $this->settingTerminal();
    }

    public function index()
    {
        return '您好！这是一个[web]示例应用';
    }

    /**
     * 设置数据终端  Home/Wap
     * @return void
     */
    private function settingTerminal()
    {
        $terminal = $this->checkTerminal(); // 检测终端
        $this->app = in_array($terminal, ['Wap', 'Xcx']) ? 'Wap' : 'Home';
        $this->terminal = $terminal;
    }

    private function checkTerminal(): string
    {
        $terminal = 'home'; // 默认为PC端
        if (check_mobile()) $terminal = 'wap'; // 如果是手机端设备访问，则设置为手机端
//        else if ($_SERVER['SERVER_NAME'] == $this->Config['wap_url']) $terminal = 'wap'; // 如果是手机端域名访问，则设置为手机端
//        elseif (cookie('phone') == 1) $terminal = 'wap'; // 如果是手机端标识COOKIE存在，则为手机端访问
        return $terminal;
    }
}
