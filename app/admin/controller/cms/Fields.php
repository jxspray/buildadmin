<?php

namespace app\admin\controller\cms;

use app\common\controller\Backend;

/**
 * 模型字段管理
 *
 */
class Fields extends Backend
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
        $this->model = new \app\admin\model\cms\Fields;
    }

    public function index()
    {
        $moduleid       = $this->request->get("moduleid/d", 0);
        $this->request->filter(['strip_tags', 'trim']);
        if ($this->request->param('select')) {
            $this->select();
        }

        list($where, $alias, $limit, $order) = $this->queryBuilder();
        $res = $this->model
            ->field($this->indexField)
            ->withJoin($this->withJoinTable, $this->withJoinType)
            ->alias($alias)
            ->where($where)
            ->where('moduleid', $moduleid)
            ->order($order)
            ->paginate($limit);

        $this->success('', [
            'list'   => $res->items(),
            'total'  => $res->total(),
            'remark' => get_route_remark(),
        ]);
    }
}
