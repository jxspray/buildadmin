<?php

namespace app\admin\model\cms;

use ba\cms\utils\Sql;

/**
 * Module
 * @controllerUrl 'cmsModule'
 *
 *
 */
class Module extends \think\Model
{
    // 表名
    protected $name = 'cms_module';

    // 自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';

    protected $createTime = 'create_time';
    protected $updateTime = 'update_time';

    protected $type = [
    ];

    /**
     * @param self $model
     * @return bool
     * @throws \Exception
     * @throws \Throwable
     */
    public static function onBeforeInsert(self $model): bool
    {
        // 检查模型是否存在
        if (isset(cms("mod")[$model['name']])) throw new \Exception("模型 {$model['name']} 已存在！");

        $model['name'] = $name = strtolower($model['name']);
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
        \app\common\library\Menu::create([$menu], 'cms');
        return true;
    }

    /**
     * @param Model $model
     * @return void
     * @throws \Throwable
     */
    public static function onAfterInsert(self $model): void
    {
        if ($model->weigh == 0) {
            $pk = $model->getPk();
            $model->where($pk, $model[$pk])->update(['weigh' => $model[$pk]]);
        }
    }

    public static function onAfterWrite(self $model): void
    {
        \ba\cms\Cms::getInstance()->forceUpdate('module');
    }

    /**
     * @param Module $model
     * @return bool
     * @throws \Throwable
     */
    public static function onBeforeDelete(self $model): bool
    {
        // 执行模型卸载程序
        \ba\cms\utils\Sql::getInstance($model['name'])->deleteTable();
        /* 清空字段 */
        Fields::where('module_id', $model['id'])->delete();
        /* 删除菜单 */
        return \app\common\library\Menu::delete($model['path'], true);
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
