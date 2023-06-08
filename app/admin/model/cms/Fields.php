<?php

namespace app\admin\model\cms;

use ba\cms\SqlField;
use think\Model;

/**
 * Field
 * @controllerUrl 'cmsFields'
 */
class Fields extends Model
{
    // 表名
    protected $name = 'cms_field';

    // 自动写入时间戳字段
    protected $autoWriteTimestamp = true;

    protected $createTime = 'createtime';
    protected $updateTime = 'updatetime';

    protected $json = ['setup'];

    public static function onAfterInsert(self $model): void
    {
        if ($model->weigh == 0) {
            $pk = $model->getPk();
            $model->where($pk, $model[$pk])->update(['weigh' => $model[$pk]]);
        }
        if ($model->getSqlFieldInstance()->tableExists() && ($res = $model->getSqlFieldInstance()->getTypeResult($model->getData())) && !empty($res[0]??'')) {
            $model->getSqlFieldInstance()->execute($res[0]);
        }
    }

    public static function onAfterUpdate(self $model): void
    {
        if ($model->getSqlFieldInstance()->tableExists() && ($res = $model->getSqlFieldInstance()->getTypeResult($model->getData(), $model->getOriginData(), ['field', 'setup', 'comment'])) && !empty($res[0]??'')) {
            $model->getSqlFieldInstance()->execute($res[0]);
        }
    }

    public static function onAfterDelete(self $model): void
    {
        $model->getSqlFieldInstance()->tableExists() && $model->getSqlFieldInstance()->deleteField($model['field']);
    }

    public function getSqlFieldInstance(){
        static $instance = null;
        if ($instance === null) {
            $data = $this->getOriginData();
            $module = cms("module");
            $moduleInfo = $module[$data['moduleid']] ?? [];
            if (empty($moduleInfo) || empty($moduleInfo['name'])) abort(502, "模型不存在");
            $instance = SqlField::getInstance($moduleInfo['name']);
        }
        return $instance;
    }

    public function getOriginData()
    {
        static $data = null;
        if ($data === null) $data = json_decode(json_encode($this->getOrigin()), true);
        return $data;
    }

    public function module()
    {
        return $this->belongsTo('module', 'moduleid');
    }
}
