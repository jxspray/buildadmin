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
    protected $cont = self::class;

    protected $quickSearchField = ['id'];

    protected $defaultSortField = 'weigh,desc';

    protected $preExcludeFields = [''];


    public function initialize()
    {
        $route = $this->request->get('route');
        if ($route && $module = \app\admin\model\cms\Module::where('path', $route)->find()) {
            $name = ucfirst($module->name);
            /* 检查控制器是否存在 */
            $controllerClass = "\app\admin\controller\cms\contents\\$name";
            if (class_exists($controllerClass)) {
                $this->cont = new $controllerClass;
                $this->cont::initialize();
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
