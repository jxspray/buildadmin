<?php

namespace app\index\controller\web\home;

use app\index\controller\Action;
use app\index\controller\web\Base;
use think\App;

class EmptyController extends Action
{
    protected Base $base;
    public function __construct(App $app)
    {
        parent::__construct($app);
        /* 实例化base */
        $this->base = new Base($app);
    }

    public function _empty(): string
    {
        $catalogs = cms('catalog');
        /* 路由判断 */
        $id = $this->request->param('id', '', 'intval');
        $catid = $this->request->param('catid', '', 'intval');
        $module = '';
        if ($this->module == 'moduleRule') {

        }
        if ($this->module == "urlRule") {
            $catdir = $this->request->param('catdir');
            if ($catdir) {
                $catid = $catid ?: cms('cat')[$catdir];
            }
            $action = $this->request->param("action");
            $modules = cms('module');
            if ($catid) {
                if ($catalogs[$catid]['module_id'] > 1) {
                    $module = $catalogs[$catid]['module'];
                } else {
                    $module = 'single';
                    $action = 'single';
                }
                $id = $catid;
            }
            if ($action == 'info') {
                foreach ($modules as $item) {
                    if ($catdir == $item['rule']) return $this->base->$action($id, $item['name']);
                }
            }
        } else {
            abort(404);
        }
        return $this->base->$action($id, $module);
    }
}
