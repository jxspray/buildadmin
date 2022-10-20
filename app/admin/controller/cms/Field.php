<?php

namespace app\admin\controller\cms;

use app\common\controller\Backend;

/**
 * 模型字段管理
 *
 */
class Field extends Backend
{
    /**
     * Field模型对象
     * @var \app\admin\model\cms\Field
     */
    protected $model = null;
    
    protected $quickSearchField = ['id'];

    protected $defaultSortField = 'id,desc';

    protected $preExcludeFields = [''];

    public function initialize()
    {
        parent::initialize();
        $this->model = new \app\admin\model\cms\Field;
    }

}
