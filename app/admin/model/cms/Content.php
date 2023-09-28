<?php

namespace app\admin\model\cms;


class Content
{
    public static function getInstance(string $name): object
    {
        return \think\facade\Db::name(\app\index\logics\CmsLogic::PREFIX . $name);
    }

//    public static function onAfterWrite(self $model): void
//    {
//        // 设置url
//        // 获取栏目目录
//        $catalog = cms('catalog')[$model->catid];
//        $model->url = $catalog['url'] . '/' . $model->id . '.html';
//        $model->save();
//    }
}
