<?php

namespace app\index\logics\handler;

class CmsCache
{
    const CACHE_GET = 'get';
    const CACHE_SET = 'set';
    const CACHE_HAS = 'has';
    const CACHE_CLEAR = 'clear';

    /**
     * @var CmsCache[] $instances
     */
    private static array $instances = [];

    private string $name;
    /**
     * @var \app\index\logics\CmsLogic $logic
     */
    private static \app\index\logics\CmsLogic $logic;

    public function __construct($name)
    {
        $this->name = $name;
    }

    public static function getInstance($name): CmsCache
    {
        if (!isset(self::$instances[$name])) self::$instances[$name] = new CmsCache($name);
        return self::$instances[$name];
    }

    public static function setLogic(\app\index\logics\CmsLogic $logic): void
    {
        self::$logic = $logic;
    }

    public function cache($type = self::CACHE_GET)
    {
        $data = null;
        if (is_array($type)) {
            $data = $type;
            $type = self::CACHE_SET;
        }
        $name = \app\index\logics\CmsLogic::PREFIX . $this->name;
        switch ($type) {
            case self::CACHE_HAS:
                return \think\facade\Cache::has($name);
            case self::CACHE_SET:
                \think\facade\Cache::set($name, $data);
                return true;
            case self::CACHE_GET:
            default:
                return \think\facade\Cache::get($name);
        }
    }

    public function checkCache(): self
    {
        if (!$this->cache(self::CACHE_HAS)) self::$logic->forceUpdate($this->name);
        return $this;
    }

}