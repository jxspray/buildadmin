<?php

namespace app\admin\controller\cms;

use app\common\controller\Backend;

/**
 * 栏目管理
 *
 */
class Catalog extends Backend
{
    /**
     * Catalog模型对象
     * @var \app\admin\model\cms\Catalog
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
