<?php

namespace app\index\logics\handler;

use app\index\logics\CmsLogic;

class Type
{
    const ALLOW_TYPE = ['module', 'catalog', 'rule', 'fields'];
    private array $TYPE = [];

    private array $param = [];

    public function __construct(string $type = null)
    {
//        $this->ALLOW_TYPE = $allow_type;
        $this->TYPE = $this->handleType($type);
    }

    public function handleType($type): array
    {
        $t = [];
        if (!$type || $type === true) $type = self::ALLOW_TYPE;
        else {
            switch ($type) {
                case is_string($type):
                    $type = explode(",", $type);
                    break;
                case is_numeric($type):
                    $type = isset($this->ALLOW_TYPE[$type]) ? [$this->ALLOW_TYPE[$type]] : [];
                    break;
                default:
            }
        }

        foreach ($type as $item) {
            $item = trim($item);
            if (in_array($item, self::ALLOW_TYPE)) $t[] = $item;
        }
        return $t;
    }

    public function setType($type): self
    {
        $this->TYPE = $this->handleType($type);
        return $this;
    }

    public function getType(): array
    {
        return $this->TYPE;
    }

    public function setModule($name): bool
    {
        if (preg_match('/field_\d/', $name)) {
            list($type, $id) = explode("_", $name);
            if ($type == 'field' && !in_array($name, $this->TYPE)) {
                $module = cms('module');
                if (!isset($module[$id])) return false;
                $this->setParam($name, 'type', "fields")->setParam($name, 'module_id', $id);
                $this->TYPE[] = $name;
            }
        }
        if (in_array($name, $this->TYPE)) {
            return true;
        }
        return false;
    }

    public static function getInstance($name): self|null
    {
        $instance = new self();
        if ($instance->check($name)) return $instance;
        else return null;
    }

    public function check($name): bool
    {
        if (preg_match('/field_\d/', $name)) {
            list($type, $id) = explode("_", $name);
            $module = cms('module');
            if (!isset($module[$id])) return false;
            $moduleName = $module[$id]['name'];

            $name = 'fields';

        }
        if (in_array($name, self::ALLOW_TYPE)) return true;
//        $this->name = $moduleName;
        return false;
    }

    private function setParam($name, $query, $value): static
    {
        $this->param[$name][$query] = $value;
        return $this;
    }

    public function getParam($name)
    {
        return $this->param[$name] ?? false;
    }
}