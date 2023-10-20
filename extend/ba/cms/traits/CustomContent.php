<?php

namespace ba\cms\traits;

use app\admin\model\cms\Content;
use think\Model;

trait CustomContent
{
    public static array $mod = [];

    protected string $moduleName = '';
    protected array $moduleData = [];
    public function __construct(string|null $name, object|array $data = [])
    {
        if ($name) $this->name = $name;
        parent::__construct($data);
    }

    public static function getInstance(string $name, array $data = []): object
    {
        if (!count(self::$mod)) self::$mod = cms("mod");
        if (!isset(self::$mod[$name])) abort(500, '模型不存在');
        $module = cms('module')[self::$mod[$name]];
        $instance = new self(\app\index\logics\CmsLogic::PREFIX . $name, $data);
        $instance->moduleName = $name;
        $instance->moduleData = $module;
        return $instance;
    }

    /**
     * 创建新的模型实例.
     *
     * @param array $data 数据
     * @param mixed $where 更新条件
     * @param array $options 参数
     *
     * @return self
     */
    public function newInstance(array $data = [], $where = null, array $options = []): self
    {
        $model = self::getInstance($this->moduleName, $data);

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

    public function getUrlAttr($value, $data): string
    {
        // 检查是否启动了路由模式
        $rule = $this->moduleData['rule'];
        if (!$rule) return $value;
        return "/$rule/{$data['id']}.html";
    }
}
