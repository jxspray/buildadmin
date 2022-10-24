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
        $moduleInfo = Module::get($model['moduleid']);
        $name = strtolower($moduleInfo['name']);
        $field = strtolower($model['field']);
        if (empty($name)) return;
        $prefix = env('database.prefix', 'ba_');
        $tableName = "cms_$name";
        $table = $prefix . "_" . $tableName;

        /* 检查数据库是否存在 */
        if (!Db::query("DESC `$table` `$field`")) {
            list($sql, $fdata) = (new SqlField($table, 'ADD'))->$model['type']($field, $model['setup']);
            Db::query("CREATE TABLE `$table` ($sql) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='{$model['title']}'");
//            (new Field())->saveAll($fdata);
        }
    }

    public static function onAfterUpdate(self $model): void
    {
        $model = $model->getData();
        $module = CmsLogic::getInstance()->module;
        $moduleInfo = $module[$model['moduleid']];
        if (empty($moduleInfo['name'])) return;
        $type = $model['type'];
        list($sql, $fdata) = SqlField::getInstance($moduleInfo['name'])->$type($model);
        var_dump($sql);
    }

}
