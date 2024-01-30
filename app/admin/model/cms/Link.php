<?php

namespace app\admin\model\cms;

use think\Model;

/**
 * Link
 */
class Link extends Model
{
    // 表名
    protected $name = 'cms_link';

    // 自动写入时间戳字段
    protected $autoWriteTimestamp = true;

    // 字段类型转换
    protected $type = [
        'delete_time' => 'timestamp:Y-m-d H:i:s',
    ];

    protected static function onAfterInsert($model)
    {
        if ($model->weigh == 0) {
            $pk = $model->getPk();
            if (strlen($model[$pk]) >= 19) {
                $model->where($pk, $model[$pk])->update(['weigh' => $model->count()]);
            } else {
                $model->where($pk, $model[$pk])->update(['weigh' => $model[$pk]]);
            }
        }
    }
}