<?php
declare (strict_types = 1);

namespace app\index\controller\web;

use app\index\logic\CmsLogic;
use app\index\controller\Action;
use think\App;

class Base extends Action
{
    protected $terminal;
    protected $categorys;

    public function __construct(App $app)
    {
        parent::__construct($app);
        // 设置终端
        $this->settingTerminal();
        $this->categorys = CmsLogic::$catalogList;
    }

    public function catalog($catid = '', $module = ''){
        if (empty($catid)) $catid = $this->request->param("catid", '', 'intval');

        if ($catid) {
            $cat = $this->categorys[$catid];

        } else abort(404);
    }

    public function single($catid = '', $module = '')
    {
        if (empty($catid)) $catid = $this->request->param("catid", '', 'intval');

        if ($catid) {
            $cat = $this->categorys[$catid];
            $cat['catid'] = $catid;
            $cat['catname'] = $cat['title'];
            unset($cat['id'], $cat['title']);
            $this->assign($cat);
        } else abort(404);
        return $this->fetch($cat['template_info']);
    }

    /**
     * 设置数据终端  Home/Wap
     * @return void
     */
    private function settingTerminal()
    {
        $terminal = $this->checkTerminal(); // 检测终端
        $this->app = in_array($terminal, ['wap', 'xcx']) ? 'wap' : 'home';
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
