<?php

namespace ba\cms\handler;


class Cache
{
    const CACHE_GET = 'get';
    const CACHE_SET = 'set';
    const CACHE_HAS = 'has';
    const CACHE_CLEAR = 'clear';

    /**
     * @var Cache[] $instances
     */
    private static array $instances = [];

    private string $name;
    /**
     * @var \ba\cms\Cms $logic
     */
    private static \ba\cms\Cms $logic;

    public function __construct($name)
    {
        $this->name = $name;
    }

    public static function getInstance($name): self
    {
        if (!isset(self::$instances[$name])) self::$instances[$name] = new self($name);
        return self::$instances[$name];
    }

    public static function setLogic(\ba\cms\Cms $logic): void
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
        $name = \ba\cms\Cms::PREFIX . $this->name;
        switch ($type) {
            case self::CACHE_HAS:
                return \think\facade\Cache::has($name);
            case self::CACHE_SET:
                \think\facade\Cache::tag('cms')->set($name, $data);
                return true;
            case self::CACHE_GET:
            default:
//                \think\facade\Cache::delete($name);
                return \think\facade\Cache::get($name);
        }
    }

    public function checkCache(): self
    {
        if (!$this->cache(self::CACHE_HAS)) self::$logic->forceUpdate($this->name);
        return $this;
    }

}
