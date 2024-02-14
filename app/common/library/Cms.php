<?php

namespace app\common\library;

use think\Model;

class Cms
{
    public function getModel(string $modelName): Model
    {
        $namespace = "\\app\\common\\model\\cms\\$modelName";
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
}