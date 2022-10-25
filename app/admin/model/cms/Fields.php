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
        if ($data['field'] != $originData['field'] || $data['setup'] != $originData['setup'] || $data['comment'] != $originData['comment']) {
            $model->executeField($data, $originData);
        }
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
