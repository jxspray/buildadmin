<?php

namespace app\admin\controller\cms;

class Catalog extends Base
{
    /**
     * Catalog模型对象
     * @var \app\admin\model\cms\Catalog
     */
    protected $model = null;
    
    protected $quickSearchField = ['id'];

    protected $defaultSortField = 'weigh,desc';

    protected $preExcludeFields = [''];

    protected $withJoinTable = [];

    use \app\admin\traits\TreeTrait;
    public function initialize()
    {
        parent::initialize();
        $this->model = new \app\admin\model\cms\Catalog;

        $this->treeInit();
    }

    public function index()
    {
        if ($this->request->param('select')) {
            $this->select();
        }

        $this->success('', [
            'list'   => $this->getCatalog(),
            'remark' => get_route_remark()
        ]);
    }

    public function select()
    {
        $data = $this->getCatalog();
        if ($this->assembleTree) {
            $data = $this->tree->assembleTree($this->tree->getTreeArray($data, 'title'));
//            array_unshift($data, ['id'=>0, 'title'=>'一级栏目']);
        }
        $this->success('', [
            'options' => $data
        ]);
    }

    public function getCatalog()
    {
        list($where, $alias, $limit, $order) = $this->queryBuilder();
        $pk      = $this->model->getPk();
        $initKey = $this->request->get("initKey/s", $pk);

        if ($this->keyword) {
            $keyword = explode(' ', $this->keyword);
            foreach ($keyword as $item) {
                $where[] = [$this->quickSearchField, 'like', '%' . $item . '%'];
            }
        }

        if ($this->initValue) {
            $where[] = [$initKey, 'in', $this->initValue];
        }
        $data = $this->model
            ->withJoin($this->withJoinTable, $this->withJoinType)
            ->alias($alias)
            ->where($where)
            ->order($order)->select()->toArray();

        return $this->assembleTree ? $this->tree->assembleChild($data) : $data;
    }
}