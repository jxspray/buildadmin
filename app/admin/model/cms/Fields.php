<?php

namespace app\admin\model\cms;

use app\index\logics\CmsLogic;
use ba\cms\SqlField;
use think\facade\Db;
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
    protected $autoWriteTimestamp = false;

    protected $createTime = false;
    protected $updateTime = false;

    protected $json = ['setup'];

    public static function onAfterInsert(self $model): void
    {
        $model->executeField($model->getData());
    }

    public static function onAfterUpdate(self $model): void
    {
        $data = $model->getData();
        $originData = $model->getOriginData();
        if ($model->updateFieldCheck(['field', 'setup', 'comment'], $data, $originData)) $model->executeField($data, $originData);
    }

    /**
     * 检查更新时字段值是否改变
     * @param $fields
     * @param $data
     * @param $originData
     * @return bool
     */
    public function updateFieldCheck($fields, $data, $originData): bool
    {
        foreach ($fields as $field) {
            if ($data[$field] != $originData[$field]) return true;
        }
        return false;
    }

    public function executeField($data, $originData = null){
        $module = CmsLogic::getInstance()->module;
        $moduleInfo = $module[$data['moduleid']];
        if (empty($moduleInfo['name'])) return;
        list($sql) = SqlField::getInstance($moduleInfo['name'])->getTypeResult($data, $originData);
        if ($sql) Db::execute($sql);
    }

    public function getOriginData()
    {
        return json_decode(json_encode($this->getOrigin()), true);
    }
}
