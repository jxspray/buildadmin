<?php

namespace app\admin\model\cms;

/**
 * Module
 * @controllerUrl 'cmsModule'
 */
class Module extends \think\Model
{
    // 表名
    protected $name = 'cms_module';

    // 自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';

    protected $createTime = 'createtime';
    protected $updateTime = 'updatetime';

    protected $type = [
    ];

    /**
     * @param self $model
     * @return bool
     * @throws \Exception
     */
    public static function onBeforeInsert(self $model): bool
    {
        /* 检查数据表是否存在 */
        if (\ba\cms\CmsSql::getInstance($model['name'])->tableExists()) throw new \Exception("数据表已存在！");

        $model['name'] = $name = strtolower($model['name']);
        $model['path'] = "cms/content/$name";
        if (empty($name)) return false;
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
        $name = $model['name'];

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
    }

    public static function onAfterWrite(self $model): void
    {
        \app\index\logics\CmsLogic::getInstance()->forceUpdate('module');
    }

    /**
     * @param Module $model
     * @return bool
     * @throws \Throwable
     */
    public static function onBeforeDelete(self $model): bool
    {
        // 执行模型卸载程序
        $cmsSqlInstance = \ba\cms\CmsSql::getInstance($model['name']);
        /* 删除表 */
        $cmsSqlInstance->tableExists() && $cmsSqlInstance->deleteTable();
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
