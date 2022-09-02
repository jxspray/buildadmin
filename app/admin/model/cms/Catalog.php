<?php

namespace app\admin\model\cms;

use think\Model;

/**
 * Catalog
 * @property integer $id
 * @property integer $weigh
 * @controllerUrl 'cmsCatalog'
 */
class Catalog extends Model
{
    // 表名
    protected $name = 'cms_catalog';

    // 自动写入时间戳字段
    protected $autoWriteTimestamp = false;

    protected $createTime = false;
    protected $updateTime = false;

    protected static function onAfterInsert(self $model)
    {
        if ($model->weigh == 0) {
            $pk = $model->getPk();
            $model->where($pk, $model[$pk])->update(['weigh' => $model[$pk]]);
        }
    }

    public static function onAfterWrite(self $model): void
    {
        \app\common\logic\CmsLogic::updateCatalog($model->getData());
    }

    public static function onAfterDelete(self $model): void
    {
        \app\common\logic\CmsLogic::updateCatalog($model->id, true);
    }

    public function getGroupIdAttr($value, $row)
    {
        return !$value ? '' : $value;
    }

    public function getFieldAttr($value, $row)
    {
        return !$value ? '' : $value;
    }

    public function getLinksValueAttr($value, $row)
    {
        return !$value ? '' : $value;
    }

    public function getPidAttr($value){
        return !$value ? '' : $value;
    }

    public function parentCatalog(): \think\model\relation\BelongsTo
    {
        return $this->belongsTo(self::class, 'id', 'pid');
    }

    public static function getColumnAll($where = []){
        return self::where($where)->column('*', 'id');
    }

    public static function getColumnRuleAll($where = [])
    {
        return self::where($where)->column('id', 'seo_url');
    }
}