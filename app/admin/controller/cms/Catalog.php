<?php

namespace app\admin\controller\cms;

use app\common\controller\Backend;
use ba\Tree;

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

    /**
     * @var Tree
     */
    protected $tree = null;

    protected $preExcludeFields = ['createtime', 'updatetime'];

    protected $quickSearchField = 'title';

    protected $keyword = false;

    protected $modelValidate = false;

    public function initialize()
    {
        parent::initialize();
        $this->model = new \app\admin\model\cms\Catalog;
        $this->tree  = Tree::instance();

        $this->keyword = $this->request->request("quick_search");
    }

    public function index()
    {
        if ($this->request->param('select')) {
            $this->select();
        }

        $this->success('', [
            'list'   => $this->getCatalogs(),
            'remark' => get_route_remark(),
        ]);
    }

    protected function getCatalogs($where = []): array
    {
        $rules = $this->getCatalogList($where);
        return $this->tree->assembleChild($rules);
    }

    /**
     * 重写select方法
     */
    public function select()
    {
        $isTree = $this->request->param('isTree');
        $data   = $this->getCatalogs();

        if ($isTree && !$this->keyword) {
            $data = $this->tree->assembleTree($this->tree->getTreeArray($data, 'title'));
        }
        $this->success('', [
            'options' => $data
        ]);
    }

    protected function getCatalogList($where = [])
    {
        if ($this->keyword) {
            $keyword = explode(' ', $this->keyword);
            foreach ($keyword as $item) {
                $where[] = [$this->quickSearchField, 'like', '%' . $item . '%'];
            }
        }

        // 读取用户组所有权限规则
        return $this->model
            ->where($where)
            ->order('weigh desc,id asc')
            ->select();
    }
}
