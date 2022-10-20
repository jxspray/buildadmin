<?php

namespace app\admin\controller\routine;

use app\common\controller\Backend;

/**
 * 通知公告管理
 *
 */
class Notice extends Backend
{
    /**
     * Notice模型对象
     * @var \app\admin\model\Notice
     */
    protected $model = null;

    protected $quickSearchField = ['id'];

    protected $defaultSortField = 'weigh,desc';

    protected $preExcludeFields = ['createtime', 'updatetime'];

    public function initialize()
    {
        parent::initialize();
        $this->model = new \app\admin\model\Notice;
    }

    public function add()
    {
        $this->request->filter('trim,htmlspecialchars');
        parent::add();
    }

    public function edit($id = null)
    {
        $this->request->filter('trim,htmlspecialchars');
        parent::edit($id);
    }
}