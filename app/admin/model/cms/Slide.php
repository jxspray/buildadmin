<?php

namespace app\admin\model\cms;

use think\Model;

/**
 * Slide
 */
class Slide extends Model
{
    // 表名
    protected $name = 'cms_slide';

    // 自动写入时间戳字段
    protected $autoWriteTimestamp = true;

    // 字段类型转换
    protected $type = [
        'groups'      => 'json',
        'delete_time' => 'timestamp:Y-m-d H:i:s',
        'extends'     => 'json',
        'field'     => 'json',
    ];


    public function getGroupsAttr($value): array
    {
        return !$value ? [] : json_decode($value, true);
    }

    public function getExtendsAttr($value): array
    {
        return !$value ? [] : json_decode($value, true);
    }

    public function getFieldAttr($value): array
    {
        return !$value ? [] : json_decode($value, true);
    }
}
