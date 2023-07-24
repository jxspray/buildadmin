<?php

namespace app\admin\controller\cms;

use app\common\controller\Backend;
use app\index\logics\CmsLogic;
use ba\cms\SqlField;
use think\db\exception\PDOException;
use think\exception\ValidateException;

/**
 * 模型管理
 *
 */
class Module extends Backend
{
    protected string|array $quickSearchField = ['id'];

    protected string|array $defaultSortField = 'weigh,desc';

    public function initialize(): void
    {
        parent::initialize();
        $this->model = new \app\admin\model\cms\Module;
    }

    public function add(): void
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
            $this->model->startTrans();
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
                $this->model->commit();
            } catch (ValidateException|PDOException|\Exception $e) {
                $this->model->rollback();
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
            $this->model->startTrans();
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
                $this->model->commit();
            } catch (ValidateException|PDOException|\Exception $e) {
                $this->model->rollback();
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

    public function createTemplateField(): void
    {
        $module_id = $this->request->post('module_id');
        $module = CmsLogic::getInstance()->module;
        $moduleInfo = $module[$module_id] ?? [];
        if (empty($moduleInfo) || empty($moduleInfo['name'])) abort(502, "模型不存在");
        $instance = SqlField::getInstance($moduleInfo['name'], "CREATE");
        !$instance->tableExists() && $instance->createTable($moduleInfo);

        $this->success("模板字段创建成功");
    }

}
