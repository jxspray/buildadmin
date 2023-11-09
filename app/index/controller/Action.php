<?php

/**
 * Action控制器基类 抽象类
 * 仅允许首页(index)、单页(single)、列表(catalog)、详情页(info)页面路由调用
 */

namespace app\index\controller;

class Action extends \app\BaseController
{
    private static array $verityModule = ['index', 'urlRule'];
    private static array $verityAction = ['index', 'catalog', 'info'];
    protected mixed $action;
    protected mixed $module;
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
        if (!in_array($this->module, self::$verityModule)) abort(404);
        if (!in_array($this->action, self::$verityAction)) abort(404);

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
        $namespace = \ba\cms\Cms::basePath . "\\{$this->pattern}\\" . ucfirst($this->module);
        $action = $this->action;
        /* 如果控制不存在 */
        if (!class_exists($namespace)) {
            $namespace = \ba\cms\Cms::basePath . "\\{$this->pattern}\\EmptyController";
            $action = "_empty";
            if (!method_exists($namespace, $action)) abort(404);
        }
        return app($namespace)->$action();
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
