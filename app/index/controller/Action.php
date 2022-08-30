<?php

/**
 * Action控制器基类 抽象类
 * 仅允许首页(index)、单页(single)、列表(catalog)、详情页(info)页面路由调用
 */
namespace app\index\controller;

use app\BaseController;
use think\App;

class Action extends BaseController
{
    private static $verityModule = ['index', 'urlRule'];
    private static $verityAction = ['index', 'catalog', 'info'];
    private $basePath = "app\\web\\controller";
    protected $app, $module, $action;

    public function __construct(App $app)
    {
        parent::__construct($app);
        $this->app = input("app", 'home');
        $this->module = input("module", 'index');
        $this->action = input("action", 'index');
        /* 检查action是否合规 */
        if (!in_array($this->module, self::$verityModule)) abort(404);
        if (!in_array($this->action, self::$verityAction)) abort(404);
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
            $namespace = "{$this->basePath}\\{$this->app}\\EmptyController";
            $action = "_empty";
            if (!method_exists($namespace, $action)) abort(404);
        }

        return app($namespace)->$action();
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