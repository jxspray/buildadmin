<?php

namespace app\admin\controller\cms;

use app\common\controller\Backend;
use app\index\logics\CmsLogic;
use ba\cms\SqlField;
use think\db\exception\PDOException;
use think\exception\ValidateException;
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

    public function add()
    {
        if ($this->request->isPost()) {
            $data = $this->request->post();
            if (!$data) {
                $this->error(__('Parameter %s can not be empty', ['']));
            }

            $data = $this->excludeFields($data);
            if ($this->dataLimit && $this->dataLimitFieldAutoFill) {
                $data[$this->dataLimitField] = $this->auth->id;
            }

            $result = false;
            Db::startTrans();
            try {
                // 模型验证
                if ($this->modelValidate) {
                    $validate = str_replace("\\model\\", "\\validate\\", get_class($this->model));
                    if (class_exists($validate)) {
                        $validate = new $validate;
                        if ($this->modelSceneValidate) $validate->scene('add');
                        $validate->check($data);
                    }
                }
                $result = $this->model->save($data);
                Db::commit();
            } catch (ValidateException|PDOException|\Exception $e) {
                Db::rollback();
                $this->error($e->getMessage());
            }
            if ($result !== false) {
                $this->success(__('Added successfully'), $this->model->getData());
            } else {
                $this->error(__('No rows were added'));
            }
        }

        $this->error(__('Parameter error'));
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
                $this->success(__('Update successful'), $row->getData());
            } else {
                $this->error(__('No rows updated'));
            }

        }

        $this->success('', [
            'row' => $row
        ]);
    }

    public function createTemplateField(){
        $moduleid = $this->request->post('moduleid');
        $module = CmsLogic::getInstance()->module;
        $moduleInfo = $module[$moduleid] ?? [];
        if (empty($moduleInfo) || empty($moduleInfo['name'])) abort(502, "模型不存在");
        $instance = SqlField::getInstance($moduleInfo['name'], "CREATE");
        !$instance->tableExists() && $instance->createTable($moduleInfo);

        $this->success("模板字段创建成功");
    }
}
