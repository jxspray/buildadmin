<?php

namespace app\index\logics\handler;

use app\index\logics\CmsLogic;

class Type
{
    private $ALLOW_TYPE = [];
    private $TYPE = [];

    private $param = [];

    public function __construct($allow_type, $type = null)
    {
        $this->ALLOW_TYPE = $allow_type;
        $this->TYPE = $this->handleType($type);
    }

    public function handleType($type): array
    {
        $t = [];
        if (!$type || $type === true) $type = $this->ALLOW_TYPE;
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
            if (in_array($item, $this->ALLOW_TYPE)) $t[] = $item;
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
                $this->setParam($name, 'type', $type)->setParam($name, 'moduleid', $id);
                $this->TYPE[] = $name;
            }
        }
        if (in_array($name, $this->TYPE)) {
            return true;
        }
        return false;
    }

    private function setParam($name, $query, $value)
    {
        $this->param[$name][$query] = $value;
        return $this;
    }

    public function getParam($name)
    {
        return $this->param[$name] ?? false;
    }
}