<?php

namespace app\admin\controller\cms;

use app\common\controller\Backend;
use ba\Tree;
use think\db\exception\PDOException;
use think\exception\ValidateException;
use think\facade\Db;

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

    protected $preExcludeFields = ['createtime', 'updatetime', 'fields'];

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

    protected function getCatalogList($where = []): array
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
            ->select()->toArray();
    }

    public function edit()
    {
        $id  = $this->request->param($this->model->getPk());
        $row = $this->model->find($id);
        if (!$row) {
            $this->error(__('Record not found'));
        }

        $dataLimitAdminIds = $this->getDataLimitAdminIds();
        if ($dataLimitAdminIds && !in_array($row[$this->dataLimitField], $dataLimitAdminIds)) {
            $this->error(__('You have no permission'));
        }

        if ($this->request->isPost()) {
            $data = $this->request->post();
            if (!$data) {
                $this->error(__('Parameter %s can not be empty', ['']));
            }

            $data   = $this->excludeFields($data);
            $result = false;
            Db::startTrans();
            try {
                // 模型验证
                if ($this->modelValidate) {
                    $validate = str_replace("\\model\\", "\\validate\\", get_class($this->model));
                    if (class_exists($validate)) {
                        $validate = new $validate;
                        if ($this->modelSceneValidate) $validate->scene('edit');
                        $validate->check($data);
                    }
                }
                $result = $row->save($data);
                Db::commit();
            } catch (ValidateException|PDOException|\Exception $e) {
                Db::rollback();
                $this->error($e->getMessage());
            }
            if ($result !== false) {
                $this->success(__('Update successful'));
            } else {
                $this->error(__('No rows updated'));
            }

        }

        $this->success('', [
            'row' => $row,
            'fields' => $row->fields
        ]);
    }
}
