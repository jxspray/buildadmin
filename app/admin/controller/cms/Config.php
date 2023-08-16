<?php

namespace app\admin\controller\cms;

use app\common\controller\Backend;
use Throwable;

/**
 * 系统配置
 * @property \app\admin\model\cms\Config $model
 */
class Config extends Backend
{
    protected array $noNeedLogin = ['index'];

    public function initialize(): void
    {
        parent::initialize();
        $this->model = new \app\admin\model\cms\Config();
    }

    public function index(): void
    {
        $this->success('', [
            'list'          => json_decode($this->model->where('name', 'catalog')->value('value'), true),
            'remark'        => get_route_remark(),
        ]);
    }

    public function param(): void
    {
        $this->success('', config("cms.param"));
    }
}