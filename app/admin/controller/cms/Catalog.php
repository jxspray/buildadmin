<?php

namespace app\admin\controller\cms;

use app\common\controller\Backend;
use ba\cms\Cms;
use ba\Filesystem;
use ba\Tree;
use think\db\exception\PDOException;
use think\exception\ValidateException;
use think\facade\Db;

/**
 * 栏目管理
 * @property \app\admin\model\cms\Catalog $model Catalog模型对象
 */
class Catalog extends Backend
{
    /**
     * @var Tree
     */
    protected Tree $tree;

    protected string|array $preExcludeFields = ['createtime', 'updatetime', 'fields'];

    protected string|array $quickSearchField = 'title';

    protected string|null $keyword = null;

    protected bool $modelValidate = false;

    public function initialize(): void
    {
        parent::initialize();
        $this->model = new \app\admin\model\cms\Catalog;
        $this->tree  = Tree::instance();

        $this->keyword = $this->request->request("quick_search");
    }

    public function index(): void
    {
        if ($this->request->param('select')) {
            $this->select();
        }

        $this->success('', [
            'list'   => $this->getCatalogs(),
            'remark' => get_route_remark()
        ]);
    }

    protected function getCatalogs($where = []): array
    {
        $rules = $this->getCatalogList($where);
        return $this->tree->assembleChild($rules);
    }

    public function edit(): void
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
                \think\facade\Log::error("Msg: {$e->getMessage()}; File: {$e->getFile()}; Line: {$e->getLine()}");
                $this->error($e->getMessage());
            }
            if ($result !== false) {
                $this->success(__('Update successful'));
            } else {
                $this->error(__('No rows updated'));
            }

        }
//        \think\facade\Cache::clear();
        $this->success('', [
            'row' => $row
        ]);
    }

    /**
     * 重写select方法
     */
    public function select(): void
    {
        $isTree = $this->request->param('isTree');
        $current_id = $this->request->param('current_id');
        $module_id = $this->request->param('module_id');
        $where = [];
        if ($current_id > 0) $where[] = ['id', '<>', $current_id];
        if ($module_id > 0) $where[] = ['module_id', '=', $module_id];
        $data   = $this->getCatalogs($where);

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
            ->with('module')
            ->order('weigh desc,id asc')
            ->cache()
            ->select()->toArray();
    }


    public function init(): void
    {
        $moduleList = \app\admin\model\cms\Module::select()->toArray();
        array_unshift($moduleList, ['id' => 0, 'title' => '页面']);
        $catalogList = $this->tree->assembleTree($this->tree->getTreeArray($this->getCatalogs(), 'title'));
        array_unshift($catalogList, ['id' => 0, 'title' => '无']);

        $template = [];
        // 获取所有模型模板
        $files = Filesystem::getDirFiles(root_path() . Cms::baseViewPath . "\\home", ['html']);
        $data = [];
        foreach ($files as $file) {
            $file = preg_replace('/\/(.*)\.html$/', "$1", $file);
            if (!str_contains($file, '/')) $data[$file] = $file;
        }
        $template[0]['index'] = $data;
        $template[0]['info'] = [];

        foreach (GM("module")->getColumnAll() as $module) {
            $files = Filesystem::getDirFiles(root_path() . Cms::baseViewPath . "\\home\\" . $module['name'], ['html']);
            $data = [];
            foreach ($files as $file) {
                $file = preg_replace('/\/(.*)\.html$/', "$1", $file);
                if (!str_contains($file, '/')) $data[$file] = $file;
            }
            $template[$module['id']]['index'] = $data;
            if ($module['type'] == '0') {
                $files = Filesystem::getDirFiles(root_path() . Cms::baseViewPath . "\\home\\" . $module['name'] . "\\info", ['html']);
                $data = [];
                foreach ($files as $file) {
                    $file = preg_replace('/\/(.*)\.html$/', "$1", $file);
                    if (!str_contains($file, '/')) $data[$file] = $file;
                }
                $template[$module['id']]['info'] = $data;
            }
        }

        $commonField = json_decode(\app\admin\model\cms\Config::where(['name' => "common", "group" => "catalog"])->value("value"), true);
        $this->success('', ['moduleList' => $moduleList, 'catalogList' => $catalogList, "templates" => $template, "commonField" => $commonField]);
    }
}
