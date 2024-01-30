<?php

namespace app\index\model\web;

use think\db\exception\DataNotFoundException;
use think\db\exception\DbException;
use think\db\exception\ModelNotFoundException;
use think\Model;

/**
 * Config
 */
class Slide extends Model
{
    // 表名
    protected $name = 'cms_slide';

    // 自动写入时间戳字段
    protected $autoWriteTimestamp = true;

    /**
     * @throws ModelNotFoundException
     * @throws DataNotFoundException
     * @throws DbException
     */
    public function getInfo($where): self|null
    {
        return $this->find($where);
    }

    public function list(): \think\model\relation\HasMany
    {
        return $this->hasMany('SlideData', 'slide_id');
    }
}