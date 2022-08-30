<?php

namespace app\web\controller\home;

use app\index\controller\Action;
use app\web\controller\Base;
use think\App;

class EmptyController extends Action
{
    protected $virtualRule = [
        'about' => 1,
        'about/contact' => 2
    ];

    protected $virtualCatalog = [
        1 => [
            'id' => 1,
            'moduleid' => 1,
            'module' => 'article'
        ],
        2 => [
            'id' => 2,
            'moduleid' => 2,
            'module' => 'case'
        ],
    ];

    protected $base;
    public function __construct(App $app)
    {
        parent::__construct($app);
        /* 实例化base */
        $this->base = new Base($app);
    }

    public function _empty() {
        /* 路由判断 */
        $id = $this->request->param('id', '', 'intval');
        $catid = $this->request->param('catid', '', 'intval');
//        $moduleid = $this->request->param('moduleid', '', 'intval');
//        if ($)
        if ($this->module == "urlRule") {
            $catdir = $this->request->param('catdir');
            if ($catdir) {
                $catid = $catid ?: $this->virtualRule[$catdir];
            }
            if ($catid) {
                if ($this->virtualCatalog[$catid]['moduleid'] > 0) {
                    $module = $this->virtualCatalog[$catid]['module'];
                    $action = 'catalog';
                } else {
                    $module = 'page';
                    $action = 'single';
                }
                $id = $catid;
            } else {
                abort(404);
            }
        } else {
            abort(404);
        }
        return $this->base->$action($id, $module);
    }
}