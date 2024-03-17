<?php

namespace app\common\model\cms;

use app\admin\model\cms\Module;
use ba\cms\utils\Url;
use think\Model;
use think\model\concern\SoftDelete;

class Catalog extends Model implements \app\admin\model\cms\CmsModelInterface
{
    use \ba\cms\traits\module\CustomCatalog;

    use SoftDelete;
    protected $autoWriteTimestamp = 'int';

    protected $createTime = 'createtime';
    protected $updateTime = 'updatetime';

    protected $name = "cms_catalog";
    protected $type = [
        "links_value" => 'object',
    ];

    public function get($id) {

    }

    public function getColumnAll($param = null): array
    {
        return $this->column("*", 'id');
    }

    public function getRouteAttr($value, $array)
    {
        return empty($array["seo_url"]) ? $array["id"] : $array["seo_url"];
    }

    public function getFieldAttr($value, $array): array
    {
        $field = [];
        $value = json_decode($value);
        foreach ($value as $k => $v) {
            switch ($v->type->type) {
                case 'image':
                    $field[$v->field] = full_url($v->type->value);
                case 'file':
                    $field[$v->field] = full_url($v->type->value);
                    break;
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

    public function getTopFieldAttr($value, $array): array
    {
        $field = [];
        $value = is_array($value) ? $value : json_decode($value, true);
        if (empty($value)) return [];
        foreach ($value as $k => $v) {
            switch ($v['type']['type']) {
                case 'image':
                    $field[$v['field']] = full_url($v['type']['value']);
                case 'file':
                    $field[$v['field']] = full_url($v['type']['value']);
                    break;
                case 'link-select':
                    $field[$v['field']] = Url::appoint($v['type']['value']);
                    break;
                case 'customArray':
                    $arr = $v['type']['value']['table'];
                    foreach ($arr as &$val1) {
                        foreach ($val1 as $key2 => $val2) {
                            if (is_object($val2)) {
                                $val1->$key2 = Url::appoint($val2);
                            }
                            if (empty($val2)) $val1->$key2 = '';
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

    public function module(): \think\model\relation\BelongsTo
    {
        return $this->belongsTo(Module::class, 'module_id')->joinType("left")->bind(["module_name" => "title"]);
    }
}
