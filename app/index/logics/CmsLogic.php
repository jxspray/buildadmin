<?php

namespace app\index\logics;

use app\index\logics\handler\CmsCache;
use app\index\logics\handler\Type;
use app\index\model\web\Catalog;
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
 *
 * @property $field_1
 * @property $module
 * @property $catalog
 * @property $rule
 */
class CmsLogic
{
    const PREFIX = "cms_";
    const basePath = "app\\index\\controller\\web";
    const ALLOW_TYPE = ['module', 'catalog', 'rule', 'fields'];

    private Type $typeItem;

    /**
     * @var self
     */
    protected static ?self $instance = null;

    public function __construct()
    {
        $this->typeItem = new Type(self::ALLOW_TYPE);
        CmsCache::setLogic($this);
        foreach ($this->typeItem as $value) {
            CmsCache::getInstance($value)->checkCache();
        }
    }

    public static function init(): void
    {
        self::getInstance();
    }

    public static function getInstance(): ?CmsLogic
    {
        if (is_null(self::$instance)) self::$instance = new self();
        return self::$instance;
    }

    public function forceUpdate(string $type = null): void
    {
        foreach ($this->typeItem->handleType($type) as $item) {
            if ($param = $this->typeItem->getParam($item)) {
                $item = $param['type'];
            }
            $name = ucfirst($item);
            $method = "update{$name}";
            if (method_exists(self::class, $method)) $data = self::$method(true);
            else if ($name == 'Module') {
                $namespace = "\\app\\index\\model\\web\\$name";
                if (!class_exists($namespace)) $namespace = "\\app\\index\\model\\web\\Content";
                $instance = new $namespace();
                $data = $instance->getColumnAll();
            } else if ($name == 'Field') {
                $namespace = "\\app\\index\\model\\web\\Fields";
                $instance = new $namespace();
                $data = $instance->getColumnAll($param);
            } else {
                $namespace = "\\app\\index\\model\\web\\contents\\$name";
                if (!class_exists($namespace)) $namespace = "\\app\\index\\model\\web\\Content";
                $instance = new $namespace();
                $data = $instance->getColumnAll();
            }
            CmsCache::getInstance($item)->cache($data);
        }
    }

    public static function update(\app\admin\model\cms\CmsModelInterface $instance, array $data, mixed $value, bool $isDelete): array
    {
        if (is_numeric($value) && $isDelete && isset($data[$value])) {
            unset($data[$value]);
        } else if (isset($value[$instance->getPk()])) {
            $data[$value[$instance->getPk()]] = $value;
        }
        return $data;
    }

    public static function updateCatalog(mixed $value = [], bool $isDelete = false): array
    {
        static $instance = false;
        if ($instance === false) $instance = new Catalog();
        if ($value === true) {
            $data = $instance->getColumnAll();
        } else {
            $data = self::update($instance, cms('catalog'), $value, $isDelete);
        }
        return $data;
    }

    public function getTypeItem(): Type
    {
        return $this->typeItem;
    }

    public function __call($name, $arguments)
    {
        if ($name == 'forceUpdate') self::getInstance()->forceUpdate($arguments[0]);
        else abort(500, "方法{$name}不存在");
    }

    public static function __callStatic($name, $arguments)
    {
        if ($name == 'forceUpdate') self::getInstance()->forceUpdate($arguments[0]);
        else abort(500, "方法{$name}不存在");
    }
}
