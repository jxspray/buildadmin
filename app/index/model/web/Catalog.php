<?php

namespace app\index\model\web;

use think\Model;
use think\model\concern\SoftDelete;

class Catalog extends Model implements \app\admin\model\cms\CmsModelInterface
{
//    use SoftDelete;
//    protected $autoWriteTimestamp = 'int';
//
//    protected $createTime = 'createtime';
//    protected $updateTime = 'updatetime';

    protected $name = "cms_catalog";

    public function getColumnAll($param = null): array
    {
        return $this->column("*", 'id');
    }


    public function children(): \think\model\relation\HasMany
    {
        return $this->hasMany(self::class, 'pid', 'id')->where('status', '1')->order('weigh DESC, id ASC');
    }
}
