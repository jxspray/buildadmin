<?php

namespace app\admin\controller\cms;

use app\common\controller\Backend;

/**
 * Content
 * @controllerUrl 'cmsContent'
 */
class Content extends Backend
{
    /**
     * Cms模型对象
     * @var \app\admin\model\cms\(.*)
     */
    protected $model = null;

    protected $quickSearchField = ['id'];

    protected $defaultSortField = 'weigh,desc';

    protected $preExcludeFields = [''];

    public function initialize()
    {
        $route = $this->request->get('route');
        if ($route && $module = \app\admin\model\cms\Module::where('path', $route)->find()) {
            $name = ucfirst($module->name);
            $controllerClass = "\app\admin\controller\cms\content\{$name}";
            if (class_exists($controllerClass)) {

                parent::initialize();
            }
            $modelClass = "\app\admin\model\cms\content\{$name}";
            $this->model = new $modelClass();
        }
    }

}
