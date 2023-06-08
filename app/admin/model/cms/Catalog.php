<?php

namespace app\admin\model\cms;

use app\index\logics\CmsLogic;
use app\index\logics\handler\CmsCache;
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
//        CmsLogic::getInstance()->forceUpdate('catalog');
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
        return $this->belongsTo("app\\admin\\model\\cms\\contents\\Page", 'id')->joinType("left");
    }

//    public function fields(){
//        return $this->hasMany("fields", 'moduleid', 'moduleid');
//    }

    public function module(){
        return $this->belongsTo("module", 'moduleid')->joinType("left");
    }
}
