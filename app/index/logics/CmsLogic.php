<?php

namespace app\index\logics;

use app\index\logics\handler\CmsCache;
use ba\Filesystem;

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
    const baseViewPath = "app\\index\\view\\web";
    const ALLOW_TYPE = ['module', 'catalog'];
//    const ALLOW_TYPE = ['module', 'catalog', 'rule', 'fields'];

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
        foreach (self::ALLOW_TYPE as $name) {
            $this->getType($name);
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

    public function forceUpdateAll(): void
    {
        foreach ($this->typeItem as $type) {
            $this->forceUpdate($type);
        }
    }

    public function forceUpdate(\app\index\logics\handler\Type|string $type = null): void
    {
//        $name = ucfirst($item);
        if (is_string($type)) $type = $this->getType($type);
        $name = ucfirst($type->getName());
        $method = "update{$name}";
        if (method_exists(self::class, $method)) $data = self::$method(true);
        else if ($name == 'Module') {
            $namespace = "\\app\\index\\model\\web\\$name";
            if (!class_exists($namespace)) $namespace = "\\app\\index\\model\\web\\Content";
            $instance = new $namespace();
            $data = $instance->getColumnAll();
        } else if ($name == 'Fields') {
            $instance = new \app\index\model\web\Fields();
            $data = $instance->getColumnAll($type->getParam());
        } else {
            $namespace = "\\app\\index\\model\\web\\contents\\$name";
            if (!class_exists($namespace)) $namespace = "\\app\\index\\model\\web\\Content";
            $instance = new $namespace();
            $data = $instance->getColumnAll();
        }
        CmsCache::getInstance($type->getKey())->cache($data);
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

    public static function updateModule(mixed $value = [], bool $isDelete = false): array
    {
        static $instance = false;
        if ($instance === false) $instance = new \app\index\model\web\Module();
        if ($value === true) {
            $data = $instance->getColumnAll();
        } else {
            $data = self::update($instance, cms('module'), $value, $isDelete);
        }
        $mod = [];
        foreach ($data as $datum) {
            $mod[$datum['name']] = $datum['id'];
        }
        CmsCache::getInstance('mod')->cache($mod);
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
        $cat = [];
        foreach ($data as $datum) {
            $cat[$datum['pdir'] . $datum['catdir']] = $datum['id'];
        }
        CmsCache::getInstance('cat')->cache($cat);
        return $data;
    }
    public static function updateTemplate(mixed $value = [], bool $isDelete = false): array
    {
        $template = [];
        // 获取所有模型模板
        foreach (cms("module") as $module) {
            $files = Filesystem::getDirFiles(root_path() . self::baseViewPath . "\\home\\" . $module['name'], ['html']);
            $data = [];
            foreach ($files as $file) {
                $file = preg_replace('/\/(.*)\.html$/', "$1", $file);
                $data[$file] = $file;
            }
            if ($module['type'] == '0') $template[$module['id']]['show'] = $data;
            else if ($module['type'] == '1') {
                foreach ($data as $file) {
                    if (preg_match('/^.*_show$/', $file)) $template[$module['id']]['show'][$file] = $file;
                    if (preg_match('/^.*_info$/', $file)) $template[$module['id']]['info'][$file] = $file;
                }
            }
        }
        return $template;
    }

    public function updateParam()
    {
        // 获取param
        $param = config("cms.param");
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
