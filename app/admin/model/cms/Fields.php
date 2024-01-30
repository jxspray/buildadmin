<?php

namespace app\admin\model\cms;

use think\Model;

/**
 * Field
 * @controllerUrl 'cmsFields'
 */
class Fields extends Model
{
    // 表名
    protected $name = 'cms_fields';

    // 自动写入时间戳字段
    protected $autoWriteTimestamp = true;

    protected $createTime = 'createtime';
    protected $updateTime = 'updatetime';

    protected $json = ['setup'];

    /**
     * @param Fields $model
     * @return void
     * @throws \Exception
     */
    public static function onAfterInsert(self $model): void
    {
        if ($model->weigh == 0) {
            $pk = $model->getPk();
            $model->where($pk, $model[$pk])->update(['weigh' => $model[$pk]]);
        }
        $model->getSqlFieldInstance()->saveField($model->getData());
    }

    /**
     * @param self $model
     * @return bool
     * @throws \Exception
     */
    public static function onBeforeUpdate(self $model): bool
    {
        return $model->getSqlFieldInstance()->saveField($model->getData(), $model->getOrigin());
    }

    /**
     * @param Fields $model
     * @return void
     * @throws \Exception
     */
    public static function onAfterDelete(self $model): void
    {
        $model->getSqlFieldInstance()->deleteField($model['field']);
    }

    public function getSqlFieldInstance(): \ba\cms\utils\Sql
    {
        static $instance = null;
        if ($instance === null) {
            $data = $this->getOriginData();
//            \think\facade\Cache::delete('module');
            $module = cms("module");
            $moduleInfo = $module[$data['module_id']] ?? [];
            if (empty($moduleInfo) || empty($moduleInfo['name'])) abort(502, "模型不存在!");
            $instance = \ba\cms\utils\Sql::getInstance($moduleInfo['name'], "ADD");
        }
        return $instance;
    }

    public function getOriginData()
    {
        static $data = null;
        if ($data === null) $data = $this->getOrigin();
        return $data;
    }

    public function module(): \think\model\relation\BelongsTo
    {
        return $this->belongsTo('module', 'module_id');
    }
}
