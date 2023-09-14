<?php

namespace app\index\model\web;

use think\Model;

/**
 * Config
 */
class Config extends Model
{
    // 表名
    protected $name = 'cms_config';

    // 自动写入时间戳字段
    protected $autoWriteTimestamp = true;

}