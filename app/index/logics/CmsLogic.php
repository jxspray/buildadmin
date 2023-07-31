<?php

namespace app\index\logics;

use app\index\logics\handler\CmsCache;

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

    /**
     * @var \app\index\logics\handler\Type[] $typeItem
     */
    private array $typeItem = [];

    /**
     * @var self
     */
    protected static ?self $instance = null;

    public function __construct()
    {
        CmsCache::setLogic($this);
        foreach ($this->typeItem as $name => $value) {
            CmsCache::getInstance($name)->checkCache();
        }
    }

    public static function init(): void
    {
        self::getInstance();
    }

    public static function getInstance(): self
    {
        if (is_null(self::$instance)) self::$instance = new self();
        return self::$instance;
    }

    public function forceUpdate(string $type = null): void
    {
        foreach ($this->typeItem[$type]->handleType($type) as $item) {
            if ($param = $this->typeItem[$type]->getParam($item)) {
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
        if ($instance === false) $instance = new \app\index\model\web\Catalog();
        if ($value === true) {
            $data = $instance->getColumnAll();
        } else {
            $data = self::update($instance, cms('catalog'), $value, $isDelete);
        }
        return $data;
    }

    /**
     * @param string $name
     * @return \app\index\logics\handler\Type|null
     */
    public function getType(string $name): \app\index\logics\handler\Type|null
    {
        if (!isset($this->typeItem[$name])) {
            $this->typeItem[$name] = \app\index\logics\handler\Type::getInstance($name);
        }
        return $this->typeItem[$name];
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
