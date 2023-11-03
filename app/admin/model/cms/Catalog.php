<?php

namespace app\admin\model\cms;

use ba\cms\Cms;
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
    protected $type = [
        'links_value' => 'json',
        'field' => 'json',
    ];
    protected $append = [
        'module_name'
    ];

    public static function onBeforeWrite(self $model): bool
    {
        // 获取上级
        if ($model->pid > 0 && ($catalog = cms("catalog")[$model->pid])) {
            $model->pdir = $catalog['catdir'] . "/";
        }
        $cat = $model->pdir . $model->catdir;
        if (isset(cms("cat")[$cat]) && cms("cat")[$cat] != $model->id)
            throw new \think\exception\ValidateException("栏目目录已存在");
        $model->seo_url = $model->pdir . $model->catdir;
        $model->module_id = $model->module_id ?? 0;
        $model->module = cms("module")[$model->module_id]['name']??'';
        $change_all = isset($model->change_all);
        if (isset($model->id) && $change_all) { // 多栏目设置
            // 查询子栏目
            (new self)->where('pid', $model->id)
                ->update([
                    'status' => $model->status,
                    'template_index' => $model->template_index, 'template_info' => $model->template_info
                ]);
        }
        return true;
    }

    protected static function onAfterInsert(self $model): void
    {
//        if ($model->weigh == 0) {
//            $pk = $model->getPk();
//            $model->where($pk, $model[$pk])->update(['weigh' => $model[$pk]]);
//        }
    }

    public static function onAfterWrite(self $model): void
    {
        Cms::getInstance()->forceUpdate('catalog');
    }

    public static function onAfterDelete(self $model): void
    {
        Cms::getInstance()->forceUpdate('catalog');
    }

    public function getModuleNameAttr($value, $data) {
        return cms("module")[$data['module_id']]['name']??'页面';
    }

    public function getGroupIdAttr($value, $row): string
    {
        return !$value ? '' : $value;
    }

    public function getFieldAttr($value, $row): string
    {
        return !$value ? '' : $value;
    }

    public function module()
    {
        return $this->belongsTo("module", 'module_id')->joinType("left");
    }
}
