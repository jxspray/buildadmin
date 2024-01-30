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

    /**
     * @throws \Exception
     */
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
                /* 检查数据表是否存在 */
                $instance = \ba\cms\utils\Sql::getInstance($this->model['name'], "CREATE");
                if ($instance->tableExists()) $this->error("数据表已存在！");
                // 批量生成字段
                $instance->createTable($this->model);
                $this->model->commit();
            } catch (\Throwable $e) {
                $this->model->rollback();
                \think\facade\Log::error("Msg: {$e->getMessage()}; File: {$e->getFile()}; Line: {$e->getLine()}");
                $this->error($e->getMessage());
            }
            if ($result !== false) {
//                $instance->createField($this->model);
                $this->success(__('Added successfully'), $this->model->getData());
            } else {
                $this->error(__('No rows were added'));
            }
        }

        $this->error(__('Parameter error'));
    }

    public function select(): void
    {
        list($where, $alias, $limit, $order) = $this->queryBuilder();
        $res = $this->model
            ->field($this->indexField)
            ->withJoin($this->withJoinTable, $this->withJoinType)
            ->alias($alias)
            ->where($where)
            ->where("status", "1")
            ->order($order)
            ->paginate($limit);

        $this->success('', [
            'list'   => $res->items(),
            'total'  => $res->total(),
            'remark' => get_route_remark(),
        ]);
    }
}
