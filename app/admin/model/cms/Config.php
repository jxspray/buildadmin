<?php

namespace app\admin\model\cms;

use think\Model;

/**
 * Config
 */
class Config extends Model
{
    // 表名
    protected $name = 'cms_config';

    // 自动写入时间戳字段
    protected $autoWriteTimestamp = false;

}