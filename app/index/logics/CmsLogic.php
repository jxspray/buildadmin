<?php

namespace app\index\logics;

use app\admin\model\cms\Catalog;
use think\facade\Cache;

/**
 * Created by JOVO.
 *
 * CMS static logic class
 *
 * @Class CmsLogic
 * @namespace app\index\logics
 * @Description
 * @Author jxspray@163.com
 * @Time 2022/9/1
 */
class CmsLogic
{
    const PREFIX = "cms_";
    const CACHE_GET = 'get';
    const CACHE_SET = 'set';
    const CACHE_HAS = 'has';
    const basePath = "app\\index\\controller\\web";

    public static $catalogList = false;
    public static $catalogCache = 'cms_catalog';

    public static $ruleList = false;
    public static $ruleCache = 'cms_rule';

    public static $cmsCache = [];

    const ALLOW_TYPE = ['catalog', 'rule'];

    public static function init()
    {
        foreach (self::ALLOW_TYPE as $value) {
            if (self::cmsCache($value, self::CACHE_HAS)) self::$cmsCache[$value] = self::cmsCache($value);
            else self::forceUpdate($value);
        }
    }

    public static function cmsCache($name, $type = self::CACHE_GET)
    {
        if (is_array($name)) {
            list($name, $data) = $name;
            $type = self::CACHE_SET;
        }
        $name = self::PREFIX . $name;
        switch ($type) {
            case self::CACHE_HAS:
                return Cache::has($name);
            case self::CACHE_SET:
                Cache::set($name, $data);
                break;
            case self::CACHE_GET:
            default:
                return Cache::get($name);
        }
    }

    public static function forceUpdate($type = null)
    {
        if (!$type || $type === true) $type = self::ALLOW_TYPE;
        if (is_string($type)) $type = explode(",", $type);
        foreach ($type as $item) {
            $item = trim($item);
            if (!in_array($item, self::ALLOW_TYPE)) continue;
            $name = ucfirst($item);
            $method = "update{$name}";
            if (method_exists(self::class, $method)) self::$method(true);
            else {
                $namespace = "\\app\\index\\model\\web\\contents\\$name";
                if (!class_exists($namespace)) $namespace = "\\app\\index\\model\\web\\Content";
                $instance = new $namespace();
                $data = $instance->getColumnAll();
                self::cmsCache([$item, $data]);
            }
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
