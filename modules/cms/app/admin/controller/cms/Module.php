<?php

namespace app\admin\controller\cms;

use app\common\controller\Backend;
use ba\cms\SqlField;
use think\facade\Db;

/**
 * 模型管理
 *
 */
class Module extends Backend
{
    /**
     * Module模型对象
     * @var \app\admin\model\cms\Module
     */
    protected $model = null;

    protected $quickSearchField = ['id'];

    protected $defaultSortField = 'weigh,desc';

    protected $preExcludeFields = [''];

    public function initialize()
    {
        parent::initialize();
        $this->model = new \app\admin\model\cms\Module;
    }

}
