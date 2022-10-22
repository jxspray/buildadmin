<?php

/**
 * Action控制器基类 抽象类
 * 仅允许首页(index)、单页(single)、列表(catalog)、详情页(info)页面路由调用
 */

namespace app\index\controller;

use app\BaseController;
use app\common\logic\CmsLogic;
use think\App;
use think\View;

class Action extends BaseController
{
    private static $verityModule = ['index', 'urlRule'];
    private static $verityAction = ['index', 'catalog', 'info'];
    private $basePath = "app\\web";
    protected $app, $module, $action;

    protected $view;

    public function __construct(App $app)
    {
        parent::__construct($app);
        $this->view = new View($app);

        $this->app = input("app", 'home');
        $this->module = input("module", 'index');
        $this->action = input("action", 'index');
        /* 检查action是否合规 */
        if (!in_array($this->module, self::$verityModule)) abort(404);
        if (!in_array($this->action, self::$verityAction)) abort(404);

        static $initState = false;
        if ($initState === false) {
            \app\common\logic\CmsLogic::init();
            $initState = true;
        }
    }

    /**
     * 中转流
     * @return mixed
     */
    public function index()
    {
        $namespace = "{$this->basePath}\\{$this->app}\\" . ucfirst($this->module);
        $action = $this->action;
        /* 如果控制不存在 */
        if (!class_exists($namespace)) {
            $namespace = "{$this->basePath}\\controller\\{$this->app}\\EmptyController";
            $action = "_empty";
            if (!method_exists($namespace, $action)) abort(404);
        }

        return app($namespace)->$action();
    }

    public function assign($name, $value = null)
    {
        $this->view->assign($name, $value);
    }

    public function display($value)
    {
        $template = $value;
        try {
            return $this->view->display($template);
        } catch (\Exception $e) {
            abort(404, "Template does not exist: $value");
        }
    }

    public function fetch($value)
    {
        $template = app()->getBasePath() . "/web/view/{$this->app}/$value.html";
        try {
            return $this->view->fetch($template);
        } catch (\Exception $e) {
            abort(404, $e->getMessage());
        }
    }

    public function __call($name, $arguments)
    {
//        if (in_array($name, self::$verityAction)) {
//            if (method_exists($this, '_empty'))
//        }
//        abort(404);
        return '';
    }
}