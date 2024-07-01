<?php

namespace app\api\controller;

use app\index\model\web\Catalog;
use Throwable;
use think\facade\Config;
use app\common\controller\Frontend;
use ba\cms\utils\Tree;

class Index extends Frontend
{
    protected array $noNeedLogin = ['index', 'loadRules'];

    public function initialize(): void
    {
        parent::initialize();
    }

    /**
     * 前台和会员中心的初始化请求
     * @throws Throwable
     */
    public function index(): void
    {
        $catalogHeader = [];
        $catalogFooter = [];
        // 头部底部菜单
        $catalogList = Catalog::where('status', 1)->order('weigh','desc')->append(['url', 'route'])->select()->toArray();
        $catalogList = array_combine(array_column($catalogList, 'id'), $catalogList);
        foreach ($catalogList as $val) {
            if (request()->isMobile() && $val['mobile'] === 0) continue;
            switch ($val['show']) {
                case 1:
                    $catalogHeader[] = $val;
                    $catalogFooter[] = $val;
                    break;
                case 2:
                    $catalogHeader[] = $val;
                    break;
                case 3:
                    $catalogFooter[] = $val;
                    break;
            }
        }
        $header = new Tree($catalogHeader);
        $footer = new Tree($catalogFooter);
        $catalogHeader = $header->leaf(0);
        $catalogFooter = $footer->leaf(0);
        $values = \app\index\model\web\Config::where("name", "cms")->find();
        $this->success('初始化完成', [
            'site'             => $values->value,
            'menus'            => $catalogHeader,
        ]);
    }

    public function loadRules()
    {
        $rules = [];
        // 生成模型列表规则
        // 生成模型详情规则
        // 生成单页规则

        $this->success('', $rules);
    }
}
