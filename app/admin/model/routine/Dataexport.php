<?php

namespace app\admin\model\routine;

use think\Model;
use think\model\relation\BelongsTo;

/**
 * Dataexport
 */
class Dataexport extends Model
{
    // 表名
    protected $name = 'dataexport';

    // 自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';

    protected $createTime = 'createtime';
    protected $updateTime = false;

    protected $type = [
        'lastexporttime' => 'timestamp:Y-m-d H:i:s',
        'join_table'     => 'array',
        'field_config'   => 'array',
        'where_field'    => 'array',
        'order_field'    => 'array',
        'subtask'        => 'array',
    ];

    public function admin(): BelongsTo
    {
        return $this->belongsTo(\app\admin\model\Admin::class, 'admin_id', 'id');
    }
}