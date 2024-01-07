<?php

namespace app\admin\model\cms;


use think\Model;

class Content extends Model
{
    use \ba\cms\traits\module\CustomContent;

    public static function onAfterWrite(self $model): void
    {
        // 设置url
        // 获取栏目目录
        $catalog = cms('catalog')[$model->catid];
        // 检查是否启动路由模式
        $module = cms("module")[$catalog['module_id']];
        if ($module['rule']) {
            $model->url = '/' . $module['rule'] . '/' . $model->id . '.html';
        } else {
            $model->url = '/' . $catalog['seo_url'] . '/' . $model->id . '.html';
        }
        $pk = $model->getPk();
        $model->where($pk, $model[$pk])->update(['url' => $model->url]);
    }
}
