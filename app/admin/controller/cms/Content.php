<?php

namespace app\admin\controller\cms;

use app\common\controller\Backend;

/**
 * Content
 * @controllerUrl 'cmsContent'
 */
class Content extends Backend
{
    protected self $con;
    protected bool $modelValidate = false;

    protected string|array $quickSearchField = ['id'];

    protected string|array $defaultSortField = 'weigh,desc';

    protected string|array $preExcludeFields = [];


    public function initialize(): void
    {
        $mod = $this->request->param('module');
        if ($mod && $module = \app\admin\model\cms\Module::where('name', $mod)->find()) {
            $name = ucfirst($module->name);
            /* 检查控制器是否存在 */
            $controllerClass = "\app\admin\controller\cms\contents\\$name";
            if (class_exists($controllerClass)) {
                $this->con = new $controllerClass;
                $this->con::initialize();
            } else {
                $this->con = $this;
            }
            /* 检查模型是否存在 */
            $modelClass = "\app\admin\model\cms\contents\\$name";
            if (class_exists($modelClass)) {
                $this->model = new $modelClass;
            } else {
                $this->model = \app\admin\model\cms\Content::getInstance($module->name);
            }
        } else abort(405);
    }

}
