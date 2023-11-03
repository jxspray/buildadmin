<?php

namespace app\index\model\web;

use ba\cms\utils\Url;
use think\Model;

class Catalog extends Model implements \app\admin\model\cms\CmsModelInterface
{
    use \ba\cms\traits\module\CustomCatalog;

//    use SoftDelete;
//    protected $autoWriteTimestamp = 'int';
//
//    protected $createTime = 'createtime';
//    protected $updateTime = 'updatetime';

    protected $name = "cms_catalog";
    protected $json = ['links_value'];
    protected $append = [
        'url'
    ];

    public function getColumnAll($param = null): array
    {
        return $this->column("*", 'id');
    }


    public function getFieldAttr($value, $array)
    {
        $field = [];
        foreach ($value as $k => $v) {
            switch ($v['type']['is']) {
                case 'el-link-select':
                    $field[$v['field']] = Url::appoint($v['type']['value']);
                    break;
                case 'el-array':
                    $arr = $v['type']['value']['table'];
                    foreach ($arr as $key1 => $val1) {
                        foreach (array_keys($val1) as $key2 => $val2) {
                            if (is_array($val1[$val2])) {
                                $arr[$key1][$val2] = Url::appoint((object)$val1[$val2]);
                            }
                        }
                    }
                    $field[$v['field']] = $arr;
                    break;
                default:
                    $field[$v['field']] = $v['type']['value'];
                    break;
            }
        }
        return $field;
    }

    public function children(): \think\model\relation\HasMany
    {
        return $this->hasMany(self::class, 'pid', 'id')->where('status', '1')->order('weigh DESC, id ASC');
    }
}
