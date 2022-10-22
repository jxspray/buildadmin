<?php

namespace app\index\controller\web\home;

use app\index\logics\CmsLogic;
use app\index\controller\Action;
use app\index\controller\web\Base;
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
        $catalogs = CmsLogic::$catalogList;
        /* 路由判断 */
        $id = $this->request->param('id', '', 'intval');
        $catid = $this->request->param('catid', '', 'intval');

        if ($this->module == "urlRule") {
            $catdir = $this->request->param('catdir');
            if ($catdir) {
                $catid = $catid ?: CmsLogic::$ruleList[$catdir];
            }
            if ($catid) {
                if ($catalogs[$catid]['moduleid'] > 0) {
                    $module = $catalogs[$catid]['module'];
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
