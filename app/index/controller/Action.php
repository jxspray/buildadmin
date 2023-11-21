<?php

/**
 * Action控制器基类 抽象类
 * 仅允许首页(index)、单页(single)、列表(catalog)、详情页(info)页面路由调用
 */

namespace app\index\controller;

use app\index\controller\web\Base;

class Action extends \app\BaseController
{
    const verityModule = ['index', 'urlRule', "moduleRule"];
    const verityAction = ['index', 'catalog', 'info'];
    protected string $action;
    protected string $module;
    protected string $pattern;

    protected string $layout = "default";

    public function __construct(\think\App $app)
    {
        parent::__construct($app);
        $this->initialize();

        $this->pattern = input("pattern", 'home');
        $this->module = input("module", 'index');
        $this->action = input("action", 'index');
        /* 检查action是否合规 */
//        if (!in_array($this->module, self::verityModule)) abort(404);
//        if (!in_array($this->action, self::verityAction)) abort(404);

        static $initState = false;
        if ($initState === false) {
            \ba\cms\Cms::init();
            $initState = true;
        }
    }

    // 初始化
    protected function initialize(): void
    {
        $this->assign([
            'label'         => $this->request->label,
            'system'        => $this->request->system,
            'block'         => $this->request->block,
            'crumbs'        => $this->request->crumbs,
            'pathinfo'      => $this->request->pathinfo,
            'catalog'       => $this->request->catalog,
            'catalogList'   => $this->request->catalogList,
            'catalogHeader' => $this->request->catalogHeader,
            'catalogFooter' => $this->request->catalogFooter,
            'htmlCheck'     => $this->request->htmlCheck,
        ]);
    }

    /**
     * 中转流
     * @return mixed
     */
    public function index(): string
    {
        // index
        // 直接访问 Index控制器
        // urlRule
        // 访问栏目、加载栏目数据
        // moduleRule
        // 通过模型路由访问详情页，不加载栏目数据，走默认栏目

        $module = $this->module;
        $action = $this->action;
        if ($module == 'moduleRule') {
            $namespace = \ba\cms\Cms::basePath . "\\{$this->pattern}\\" . ucfirst($this->request->param("path"));
            /* 如果模型控制器不存在 */
            if (!class_exists($namespace)) $namespace = Base::class;
            $module = $this->request->param("path");
        } else if ($module == 'urlRule') {
            $namespace = Base::class;
        } else {
            $namespace = \ba\cms\Cms::basePath . "\\{$this->pattern}\\" . ucfirst($module);
            /* 如果控制不存在 */
            if (!class_exists($namespace)) abort(404);
        }
        if (!method_exists($namespace, $action)) abort(404);
        return app($namespace)->$action($this->request->catalog['id'], $this->request->catalog['module']);
    }

    public function module() {
        $namespace = \ba\cms\Cms::basePath . "\\{$this->pattern}\\" . ucfirst($this->request->param("path"));
        /* 如果模型控制器不存在 */
        if (!class_exists($namespace)) {
            $namespace = Base::class;
        }
        if (!method_exists($namespace, $this->action)) abort(404);
        return app($namespace)->{$this->action}();

    }

    public function assign($name, $value = null): void
    {
        \think\facade\View::assign($name, $value);
    }

    public function fetch(string $value, array $args = [], bool|string $layout = true)
    {
        $template = app()->getAppPath() . "/view/web/{$this->pattern}/$value.html";
        try {
            $this->setLayout($layout);
            return \think\facade\View::fetch($template, $args);
        } catch (\Exception $e) {
            abort(404, $e->getMessage());
        }
    }

    private function setLayout($layout): void
    {
        if (!$layout) return;
        if ($layout === true) $layout = $this->layout;
        \think\facade\View::engine()->layout("web/{$this->pattern}/layout/{$layout}");
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
