<?php

namespace app\admin\controller\cms;

/**
 * 模型管理
 * @property \app\admin\model\cms\Module $model Module模型对象
 */
class Module extends \app\common\controller\Backend
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
            } catch (\Throwable $e) {
                $this->model->rollback();
                \think\facade\Log::error("Msg: {$e->getMessage()}; File: {$e->getFile()}; Line: {$e->getLine()}");
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

    /**
     * @return void
     * @throws \Exception
     */
    public function createTemplateField(): void
    {
        $module_id = $this->request->post('module_id');

        $module = cms("module");
        $moduleInfo = $module[$module_id] ?? [];
        if (empty($moduleInfo) || empty($moduleInfo['name'])) abort(502, "模型不存在");
        $instance = \ba\cms\CmsSql::getInstance($moduleInfo['name'], "CREATE");
        !$instance->tableExists() && $instance->createTable($moduleInfo);

        $this->success("模板字段创建成功");
    }

}
