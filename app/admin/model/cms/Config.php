<?php

namespace app\admin\model\cms;

use think\Model;
use Throwable;

class Config extends Model
{
    protected $name = 'cms_config';

    protected $append = [
        'value',
    ];

    protected array $jsonDecodeType = ['checkbox', 'array', 'selects'];
    protected array $needContent    = ['radio', 'checkbox', 'select', 'selects'];

    /**
     * 入库前
     * @throws Throwable
     */
    public static function onBeforeInsert($model)
    {
        if (is_array($model->rule)) {
            $model->rule = implode(',', $model->rule);
        }
    }

    public function getValueAttr($value, $row)
    {
        if (!isset($row['type'])) return $value;
        if (in_array($row['type'], $this->jsonDecodeType)) {
            return empty($value) ? [] : json_decode($value, true);
        } elseif ($row['type'] == 'switch') {
            return (bool)$value;
        } elseif ($row['type'] == 'editor') {
            return !$value ? '' : htmlspecialchars_decode($value);
        } elseif (in_array($row['type'], ['city', 'remoteSelects'])) {
            if ($value == '') {
                return [];
            }
            if (!is_array($value)) {
                return explode(',', $value);
            }
            return $value;
        } else {
            return $value ?: '';
        }
    }

    public function setValueAttr($value, $row): string
    {
        if (in_array($row['type'], $this->jsonDecodeType)) {
            return $value ? json_encode($value) : '';
        } elseif ($row['type'] == 'switch') {
            return $value ? '1' : '0';
        } elseif ($row['type'] == 'time') {
            return $value ? date('H:i:s', strtotime($value)) : '';
        } elseif ($row['type'] == 'city') {
            if ($value && is_array($value)) {
                return implode(',', $value);
            }
            return $value ?: '';
        } elseif (is_array($value)) {
            return implode(',', $value);
        }

        return $value;
    }

}