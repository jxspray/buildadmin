<?php

namespace app\index\logics\handler;

use app\index\logics\CmsLogic;
use think\facade\Cache;

class CmsCache
{
    const CACHE_GET = 'get';
    const CACHE_SET = 'set';
    const CACHE_HAS = 'has';

    private static $instances = [];

    private $name;
    /**
     * @var CmsLogic $logic
     */
    private static $logic;
    public function __construct($name)
    {
        $this->name = $name;
    }

    public static function getInstance($name){
        if (!isset(self::$instances[$name])) self::$instances[$name] = new self($name);
        return self::$instances[$name];
    }

    public static function setLogic(\app\index\logics\CmsLogic $logic)
    {
        self::$logic = $logic;
    }

    public function cache($type = self::CACHE_GET){
        if (is_array($type)) {
            $data = $type;
            $type = self::CACHE_SET;
        }
        $name = CmsLogic::PREFIX . $this->name;
        switch ($type) {
            case self::CACHE_HAS:
                return Cache::has($name);
            case self::CACHE_SET:
                Cache::set($name, $data);
                return true;
            case self::CACHE_GET:
            default:
                return Cache::get($name);
        }
    }

    public function checkCache(): self
    {
        if (!$this->cache(self::CACHE_HAS)) self::$logic->forceUpdate($this->name);
        return $this;
    }

}