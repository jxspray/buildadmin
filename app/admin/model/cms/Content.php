<?php

namespace app\admin\model\cms;


class Content extends \think\Model
{
    public static function getInstance(string $name): static
    {
        $instance = new self();
        $instance->name = \app\index\logics\CmsLogic::PREFIX . $name;
        return $instance;
    }

    public static function onAfterWrite(self $model): void
    {
        // 设置url
        // 获取栏目目录
        $catalog = cms('catalog')[$model->catid];
        $model->url = $catalog['url'] . '/' . $model->id . '.html';
        $model->save();
    }
}
