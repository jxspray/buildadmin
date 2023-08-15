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

    protected $createTime = 'create_time';
    protected $updateTime = 'update_time';
    protected $deleteTime = "delete_time";
    protected $defaultSoftDelete = null;

    protected $json = [];

    public static function onBeforeWrite(self $model): bool
    {
        // 获取上级
        if ($model->pid > 0 && ($catalog = cms("catalog")[$model->pid])) {
            $model->pdir = $catalog['catdir'] . "/";
        }
        $model->url = "/" . $model->pdir . $model->catdir . "/";
        $model->module_id = $model->module_id ?? 1;
        $model->module = cms("module")[$model->module_id]['name'];
        return true;
    }

    protected static function onAfterInsert(self $model): void
    {
        if ($model->weigh == 0) {
            $pk = $model->getPk();
            $model->where($pk, $model[$pk])->update(['weigh' => $model[$pk]]);
        }
    }

    public static function onAfterWrite(self $model): void
    {
        $model->catalogExtend()->save($model->catalogExtend);
        CmsLogic::getInstance()->forceUpdate('catalog');
        CmsLogic::getInstance()->forceUpdate('field_1');
    }

    public static function onAfterDelete(self $model): void
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

    public function catalogExtend()
    {
        return $this->belongsTo("app\\admin\\model\\cms\\contents\\CatalogExtend", 'id')->joinType("left");
    }

//    public function fields(){
//        return $this->hasMany("fields", 'module_id', 'module_id');
//    }

    public function module()
    {
        return $this->belongsTo("module", 'module_id')->joinType("left");
    }
}
