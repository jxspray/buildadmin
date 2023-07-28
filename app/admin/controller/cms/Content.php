<?php

namespace app\admin\controller\cms;

use app\common\controller\Backend;

/**
 * Content
 * @controllerUrl 'cmsContent'
 */
class Content extends Backend
{
    protected string $con = self::class;

    protected string|array $quickSearchField = ['id'];

    protected string|array $defaultSortField = 'weigh,desc';

    protected string|array $preExcludeFields = [];


    public function initialize(): void
    {
        $route = $this->request->get('route');
        if ($route && $module = \app\admin\model\cms\Module::where('path', $route)->find()) {
            $name = ucfirst($module->name);
            /* 检查控制器是否存在 */
            $controllerClass = "\app\admin\controller\cms\contents\\$name";
            if (class_exists($controllerClass)) {
                $this->con = new $controllerClass;
                $this->con::initialize();
            }
            /* 检查模型是否存在 */
            $modelClass = "\app\admin\model\cms\contents\\$name";
            if (class_exists($modelClass)) {
                $this->model = new $modelClass;
            } else {
                $this->model = new \app\admin\model\cms\Content($module->name);
            }
        } else abort(405);
    }

}
