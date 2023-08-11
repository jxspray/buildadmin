<?php

namespace app\admin\model\cms;

use app\index\logics\CmsLogic;
use think\Model;
use think\model\concern\SoftDelete;

/**
 * Catalog
 * @controllerUrl 'cmsCatalog'
 */
class Catalog extends Model
{
    use SoftDelete;
    // 表名
    protected $name = 'cms_catalog';

    // 自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';

    protected $createTime = 'createtime';
    protected $updateTime = 'updatetime';
    protected $deleteTime = "deletetime";
    protected $defaultSoftDelete = null;

    protected $json = [];

    protected static function onAfterInsert($model)
    {
        if ($model->weigh == 0) {
            $pk = $model->getPk();
            $model->where($pk, $model[$pk])->update(['weigh' => $model[$pk]]);
        }
    }

    public static function onAfterWrite(Model $model): void
    {
        $model->catalogExtend()->save($model->catalogExtend);
        CmsLogic::getInstance()->forceUpdate('catalog');
        CmsLogic::getInstance()->forceUpdate('field_1');
    }

    public static function onAfterDelete($model): void
    {
        CmsLogic::getInstance()->forceUpdate('catalog');
        CmsLogic::getInstance()->forceUpdate('field_1');
        \app\admin\model\cms\contents\CatalogExtend::where("id", $model->id)->delete();
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

    public function catalogExtend(){
        return $this->belongsTo("app\\admin\\model\\cms\\contents\\CatalogExtend", 'id')->joinType("left");
    }

//    public function fields(){
//        return $this->hasMany("fields", 'module_id', 'module_id');
//    }

    public function module(){
        return $this->belongsTo("module", 'module_id')->joinType("left");
    }
}
