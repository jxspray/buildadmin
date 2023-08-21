<?php

namespace app\admin\model\cms;


class Content extends \think\Model
{
    public function __construct(string $name, array $data = [])
    {
        $this->name = \app\index\logics\CmsLogic::PREFIX . $name;
        parent::__construct($data);
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
