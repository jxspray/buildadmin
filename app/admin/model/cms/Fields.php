<?php

namespace app\admin\model\cms;

use think\Model;

/**
 * Field
 * @controllerUrl 'cmsFields'
 */
class Fields extends Model
{
    // 表名
    protected $name = 'cms_field';

    // 自动写入时间戳字段
    protected $autoWriteTimestamp = false;

    protected $createTime = false;
    protected $updateTime = false;



    public function getSetupAttr($value, $row)
    {
        return !$value ? '' : $value;
    }
}
