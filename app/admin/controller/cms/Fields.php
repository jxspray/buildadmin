<?php

namespace app\admin\controller\cms;

use app\common\controller\Backend;
use app\index\logics\CmsLogic;

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
    protected object $model;

    protected string|array $quickSearchField = ['id'];

    protected string|array $defaultSortField = 'id,desc';

    protected string|array $preExcludeFields = [''];

    protected array $withJoinTable = ['module'];

    public function initialize(): void
    {
        parent::initialize();
        $this->model = new \app\admin\model\cms\Fields;
    }

    public function index(): void
    {
        $moduleId       = $this->request->get("module_id/d", 0);
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
            ->where('module_id', $moduleId)
            ->order($order)
            ->paginate($limit);

        $this->success('', [
            'list'   => $res->items(),
            'total'  => $res->total(),
            'remark' => get_route_remark(),
        ]);
    }

    public function getFields(): void
    {
        $route = $this->request->get('route');
        if ($route && $module = \app\admin\model\cms\Module::where('path', $route)->find()) {
            $res = $this->model->where('module_id', $module['id'])->select();
            $this->success('', $res);
        }
        $this->error("参数错误");
    }
}
