<?php

namespace app\admin\controller\cms;

use app\common\controller\Backend;

/**
 * CMS配置
 */
class Config extends Backend
{
    /**
     * Config模型对象
     * @var object
     * @phpstan-var \app\admin\model\cms\Config
     */
    protected object $model;

    protected array|string $preExcludeFields = ['id', 'type'];

    protected string|array $quickSearchField = ['id'];

    public function initialize(): void
    {
        parent::initialize();
        $this->model = new \app\admin\model\cms\Config;
    }


    /**
     * 若需重写查看、编辑、删除等方法，请复制 @see \app\admin\library\traits\Backend 中对应的方法至此进行重写
     */
}