<?php

namespace app\admin\model\cms\slide;

use think\Model;

/**
 * Data
 */
class Data extends Model
{
    // 表名
    protected $name = 'cms_slide_data';

    // 自动写入时间戳字段
    protected $autoWriteTimestamp = true;

    // 字段类型转换
    protected $type = [
        'delete_time' => 'timestamp:Y-m-d H:i:s',
    ];
    protected $append = [
        'cdn_image'
    ];

    public function getCdnImageAttr($value, $row): string
    {
        return $row['image'] ? full_url($row['image']) : '';
    }

    public function slide(): \think\model\relation\BelongsTo
    {
        return $this->belongsTo(\app\admin\model\cms\Slide::class, 'slide_id', 'id');
    }
}
