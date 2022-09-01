<?php

namespace app\common\logic;

use app\admin\model\cms\Catalog;
use think\facade\Cache;

/**
 * Created by JOVO.
 *
 * CMS static logic class
 *
 * @Class CmsLogic
 * @namespace app\common\logic
 * @Description
 * @Author jxspray@163.com
 * @Time 2022/9/1
 */
class CmsLogic
{
    public static $catalogList = false;
    public static $catalogCache = 'cms_catalog';

    public static $ruleList = false;
    public static $ruleCache = 'cms_rule';

    const ALLOW_TYPE = ['catalog', 'rule'];

    public static function init()
    {
        if (Cache::has(self::$catalogCache)) self::$catalogList = Cache::get(self::$catalogCache);
        else self::updateCatalog(true);
        if (Cache::has(self::$ruleCache)) self::$ruleList = Cache::get(self::$ruleCache);
        else self::updateRule(true);
    }

    public static function forceUpdate($type = null)
    {
        if (!$type || $type === true) $type = self::ALLOW_TYPE;
        if (is_string($type)) $type = explode(",", $type);
        foreach ($type as $item) {
            $item = trim($item);
            if (!in_array($item, self::ALLOW_TYPE)) continue;
            $method = "update" . ucfirst($item);
            if (method_exists(self::class, $method)) self::$method(true);
        }
    }

    public static function update($instance, &$data, $cache, $value, $isDelete)
    {
        if (is_numeric($value) && $isDelete && isset($data[$value])) {
            unset($data[$value]);
            Cache::set($cache, $data);
        } else if (isset($value[$instance->getPk()])) {
            $data[$value[$instance->getPk()]] = $value;
            Cache::set($cache, $data);
        }
    }

    public static function updateCatalog($value = [], $isDelete = false)
    {
        static $instance = false;
        if ($instance === false) $instance = new Catalog();
        if ($value === true) {
            $data = $instance::getColumnAll();
            Cache::set(self::$catalogCache, $data);
        } else {
            self::update($instance, self::$catalogList, self::$catalogCache, $value, $isDelete);
        }
    }

    public static function updateRule($value = [], $isDelete = false)
    {
        static $instance = false;
        if ($instance === false) $instance = new Catalog();

        if ($value === true) {
            $data = $instance::getColumnRuleAll();
            Cache::set(self::$ruleCache, $data);
        } else {
            self::update($instance, self::$ruleList, self::$ruleCache, $value, $isDelete);
        }
    }

}