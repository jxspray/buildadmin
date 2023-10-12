<?php

namespace app\admin\model\cms;


use think\Model;

class Content extends Model
{
    public function __construct(string|null $name, object|array $data = [])
    {
        if ($name) $this->name = $name;
        parent::__construct($data);
    }

    public static function getInstance(string $name): object
    {
        return new self(\app\index\logics\CmsLogic::PREFIX . $name, []);
    }

    public static function onBeforeWrite(self $model): void
    {
        // 设置url
        // 获取栏目目录
        $catalog = cms('catalog')[$model->catid];
        // 检查是否启动路由模式
        $module = cms("module")[$catalog['module_id']];
        if ($module['rule']) {
            $model->url = '/' . $module['rule'] . '/' . $model->id . '.html';
        } else {
            $model->url = $catalog['url'] . '/' . $model->id . '.html';
        }
    }



    /**
     * 创建新的模型实例.
     *
     * @param array $data    数据
     * @param mixed $where   更新条件
     * @param array $options 参数
     *
     * @return Model
     */
    public function newInstance(array $data = [], $where = null, array $options = []): Model
    {
        $model = new static($this->name, $data);

        if ($this->connection) {
            $model->setConnection($this->connection);
        }

        if ($this->suffix) {
            $model->setSuffix($this->suffix);
        }

        if (empty($data)) {
            return $model;
        }

        $model->exists(true);

        $model->setUpdateWhere($where);

        $model->trigger('AfterRead');

        return $model;
    }
}
