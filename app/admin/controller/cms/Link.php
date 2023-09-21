<?php

namespace app\admin\controller\cms;

use app\common\controller\Backend;

/**
 * 友情链接
 */
class Link extends Backend
{
    /**
     * Link模型对象
     * @var object
     * @phpstan-var \app\admin\model\cms\Link
     */
    protected object $model;

    protected string|array $defaultSortField = 'weigh,desc';

    protected array|string $preExcludeFields = ['id', 'update_time', 'create_time', 'delete_time'];

    protected string|array $quickSearchField = ['id'];

    public function initialize(): void
    {
        parent::initialize();
        $this->model = new \app\admin\model\cms\Link;
    }


    /**
     * 若需重写查看、编辑、删除等方法，请复制 @see \app\admin\library\traits\Backend 中对应的方法至此进行重写
     */
}