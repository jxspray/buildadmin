<?php

namespace app\admin\model\cms;

use app\common\library\Menu;
use app\index\logics\CmsLogic;
use ba\cms\SqlField;
use ba\Terminal;
use think\facade\Config;
use think\facade\Db;
use think\Model;

/**
 * Module
 * @controllerUrl 'cmsModule'
 */
class Module extends Model
{
    // 表名
    protected $name = 'cms_module';

    // 自动写入时间戳字段
    protected $autoWriteTimestamp = false;

    protected $createTime = false;
    protected $updateTime = false;

    public static function onBeforeInsert(Model $model)
    {
        /* 检查数据表是否存在 */
        if (SqlField::getInstance($model['name'])->tableExists()) throw new \Exception("数据表已存在！");

        $name = strtolower($model['name']);
        if (empty($name)) return false;
        $model['path'] = "cms/content/$name";
        /* 添加菜单 */
        $menu = [
            'type' => 'menu',
            'title' => $model['title'],
            'name' => $model['path'],
            'path' => $model['path'],
            'icon' => 'el-icon-ChatLineRound',
            'menu_type' => 'tab',
            'component' => "/src/views/backend/cms/content/$name/index.vue",
            'keepalive' => '1',
            'children' => [
                ['type' => 'button', 'title' => '查看', 'name' => "cms/content/$name/index"],
                ['type' => 'button', 'title' => '添加', 'name' => "cms/content/$name/add"],
                ['type' => 'button', 'title' => '编辑', 'name' => "cms/content/$name/edit"],
                ['type' => 'button', 'title' => '删除', 'name' => "cms/content/$name/del"],
                ['type' => 'button', 'title' => '快速排序', 'name' => "cms/content/$name/sortable"],
            ]
        ];
        Menu::create([$menu], 'cms');
    }

    protected static function onAfterInsert(self $model)
    {
        list($sqlStr, $fieldList) = $model->createField($model['id'], SqlField::getInstance($model['name']), $model['type']);
        $sqlFieldInstance = SqlField::getInstance($model['name']);
        if (!$sqlFieldInstance->tableExists() && $sqlFieldInstance->createTable()) {
            Db::query("CREATE TABLE `$table` ($sql) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='{$model['title']}'");
        }

        $name = strtolower($model['name']);
        if (empty($name)) return false;
        $prefix = env('database.prefix', 'build_');
        $tableName = "cms_$name";
        $table = $prefix . "_" . $tableName;

        /* 检查数据表是否存在 */
        if (!Db::query("SHOW TABLES LIKE '$table'")) {
            list($sql, $fdata) = $model->createField($model['id'], new SqlField($table), $model['type']);
            Db::query("CREATE TABLE `$table` ($sql) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='{$model['title']}'");
//            (new Field())->saveAll($fdata);
        } else return false;
    }

    public static function onAfterWrite(Model $model): void
    {
        CmsLogic::forceUpdate('module');
    }

    public static function onBeforeDelete(Model $model): bool
    {
        $sqlFieldInstance = SqlField::getInstance($model['name']);
        /* 检查数据库是否存在 */
        if (!$sqlFieldInstance->tableExists() || $sqlFieldInstance->deleteTable()) return Menu::delete($model['path'], true);
        else return false;
    }
}
