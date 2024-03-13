<?php

namespace app\common\library;

use think\Model;

/**
 * CMS
 * @package app\common\library
 * @method static cache(string $name)
 */
class Cms
{
    public function getModel(string $modelName): Model
    {
        $namespace = "\\app\\common\\model\\cms\\$modelName";
        if (!class_exists($namespace)) {
            if (!isset($this->cache("mod")['model_name'])) abort(500, "{$namespace}: Class not exist!");
            $namespace = "\\app\\common\\model\\cms\\Content";
            $instance = call_user_func([$namespace, 'getInstance'], $modelName);
            if (!class_exists($namespace)) abort(500, "{$namespace}: Class not exist!!");
        } else {
            $instance = new $namespace();
        }
        return $instance;
    }
    public function getModel1(string $modelName): Model
    {
        $namespace = "\\app\\common\\model\\cms\\$modelName";
        var_dump($namespace);die;
        if (!class_exists($namespace)) {
            if (!isset($this->cms("mod")['model_name'])) abort(500, "{$namespace}: Class not exist!");
            $namespace = "\\app\\common\\model\\cms\\Content";
            $instance = call_user_func([$namespace, 'getInstance'], $modelName);
            if (!class_exists($namespace)) abort(500, "{$namespace}: Class not exist!!");
        } else {
            $instance = new $namespace();
        }
        return $instance;
    }

    /**
     * @param string $name
     * @param string $type
     * @return array|bool
     */
    public static function cms(string $name, string $type = 'cache'): array|bool
    {
        switch ($type) {
            case 'cache':
                if (\ba\cms\Cms::getInstance()->getType($name))
                    return \ba\cms\handler\Cache::getInstance($name)->checkCache()->cache();
                return false;
        }
        return false;
    }

    public function cache(string $name)
    {
        if (\ba\cms\Cms::getInstance()->getType($name))
            return \ba\cms\handler\Cache::getInstance($name)->checkCache()->cache();
        return false;
    }

    public static function __callStatic(string $name, array $arguments)
    {
        if ($name == 'cache') return (new self())->cache($arguments[0]);
        throw new \Exception("方法{$name}不存在");
    }
}
