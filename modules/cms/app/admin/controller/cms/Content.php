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
        parent::initialize();
        $this->model = new \app\admin\model\cms\Catalog;
    }

}
