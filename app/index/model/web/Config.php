<?php

namespace app\index\model\web;

use ba\cms\utils\Url;
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

    protected $type = [
        'value' => 'json'
    ];

    public static function load(string $group, string $name)
    {
        return self::where('group', $group)->where('name', $name)->cache()->find();
    }


    public function getValueAttr($value, $array): array
    {
        if ($array['group'] == "catalog") return json_decode($value, true);
        $field = [];
        $value = is_array($value) ? $value : json_decode($value);
        foreach ($value as $k => $v) {
            switch ($v->type->type) {
                case 'link-select':
                    $field[$v->field] = Url::appoint($v->type->value);
                    break;
                case 'customArray':
                    $arr = $v->type->value->table;
                    foreach ($arr as &$val1) {
                        foreach ($val1 as $key2 => $val2) {
                            if (is_object($val2)) {
                                $val1->$key2 = Url::appoint($val2);
                            }
                            if (empty($val2)) $val1->$key2 = '';
                        }
                    }
                    $field[$v->field] = $arr;
                    break;
                default:
                    $field[$v->field] = $v->type->value;
                    break;
            }
        }
        return $field;
    }
}
