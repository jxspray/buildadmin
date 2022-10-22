<?php

namespace app\admin\model\cms;

use app\common\library\Menu;
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
        $name = strtolower($model['name']);
        if (empty($name)) return false;
        $prefix = env('database.prefix', 'build_');
        $tableName = "cms_$name";
        $table = $prefix . "_" . $tableName;

        /* 检查数据库是否存在 */
        if (!Db::query("SHOW TABLES LIKE '$table'")) {
            list($sql, $fdata) = $model->createField($model['id'], new SqlField($table), $model['type']);
            Db::query("CREATE TABLE `$table` ($sql) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='{$model['title']}'");
//            (new Field())->saveAll($fdata);
        } else return false;
    }

    public static function onBeforeDelete(Model $model)
    {
        $name = strtolower($model['name']);
        if (empty($name)) return false;
        $prefix = env('database.prefix', 'build_');
        $tableName = "cms_$name";
        $table = $prefix . "_" . $tableName;

        /* 检查数据库是否存在 */
        if (!Db::query("SHOW TABLES LIKE '$table'")) {
            list($sql, $fdata) = $model->createField($model['id'], new SqlField($table), $model['type']);
            $sql = "CREATE TABLE `$table` ($sql) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='{$model['title']}'";
            if (Db::query($sql) && (new Field())->saveAll($fdata)) return true;
            else return false;
        } else return false;
    }


    protected function createField(int $moduleid, SqlField $sqlField, $type): array
    {
        $data = [];
        $fdatas = [];
        $sqls = [];
        if ($type == 1) {
            $data[] = $sqlField->catid('catid', ['remark' => '栏目']);
            $data[] = $sqlField->title('title', ['remark' => '标题']);
            $data[] = $sqlField->text('keywords', ['remark' => '关键词']);
            $data[] = $sqlField->textarea('description', ['remark' => '描述']);
            $data[] = $sqlField->radio('status', ['default' => 0, 'listorder' => 99, 'remark' => '状态']);
        } else {
            $data[] = $sqlField->radio('status', ['default' => 1, 'listorder' => 99, 'remark' => '状态']);
        }
        $sqls[] = "`id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID'";
        $sqls[] = "`listorder` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '语言ID'";
//        $sqls[] = "`lang` tinyint(1) unsigned NOT NULL DEFAULT '0'";

        foreach ($data as $datum) {
            $sqls[] = $datum[0];
            $datum[1]['moduleid'] = $moduleid;
            $fdatas[] = $datum[1];
        }

        $sqls[] = "PRIMARY KEY (`id`)";
        return [implode(", ", $sqls), $fdatas];
    }
}
