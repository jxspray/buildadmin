<?php

namespace app\admin\model\cms;

use app\common\library\Menu;
use app\index\logics\CmsLogic;
use ba\cms\SqlField;
use ba\Terminal;
use think\db\exception\DataNotFoundException;
use think\db\exception\DbException;
use think\db\exception\ModelNotFoundException;
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
    protected $autoWriteTimestamp = 'int';

    protected $createTime = 'createtime';
    protected $updateTime = 'updatetime';

    protected $type = [
    ];

    public static function onBeforeInsert(self $model): bool
    {
        /* 检查数据表是否存在 */
        if (SqlField::getInstance($model['name'])->tableExists()) throw new \Exception("数据表已存在！");

        $name = strtolower($model['name']);
        $model['path'] = "cms/content/$name";
        if (empty($name)) return false;
        return true;
    }

    /**
     * @throws ModelNotFoundException
     * @throws DataNotFoundException
     * @throws DbException
     */
    public static function onAfterInsert(Model $model): void
    {
        if ($model->weigh == 0) {
            $pk = $model->getPk();
            $model->where($pk, $model[$pk])->update(['weigh' => $model[$pk]]);
        }

        $name = strtolower($model['name']);
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

    public static function onAfterWrite(self $model): void
    {
        CmsLogic::getInstance()->forceUpdate('module');
    }

    /**
     * @throws ModelNotFoundException
     * @throws DataNotFoundException
     * @throws DbException
     * @throws \Throwable
     */
    public static function onBeforeDelete(self $model): bool
    {
        // 执行模型卸载程序
        $sqlFieldInstance = SqlField::getInstance($model['name']);
        /* 删除表 */
        $sqlFieldInstance->tableExists() && $sqlFieldInstance->deleteTable();
        /* 清空字段 */
        (new Fields)->where('module_id', $model['id'])->delete();
        /* 删除菜单 */
        return Menu::delete($model['path'], true);
    }

    public function setGenerateAttr($value, $data): string
    {
        $value['table']['name'] = $data['name'];
        return json_encode($value, JSON_UNESCAPED_UNICODE);
    }


    public function getGenerateAttr($value, $data)
    {
        return json_decode($value, true);
    }
}
