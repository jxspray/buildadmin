<?php

namespace ba\cms\handler;

class Field
{
    const ALLOW_TYPE = ['module', 'catalog', 'rule', 'fields'];
    private array $TYPE = [];

    private array $param = [];

    private int $id;

    public function __construct()
    {
    }

    public static function getInstance($name): self|null
    {
        $instance = new self();
        if ($instance->check($name)) return $instance;
        else return null;
    }

    public function handleType($type): array
    {
    }

    public function setType($type): self
    {
    }

    public function getType(): array
    {
    }

    public function check($id): bool
    {
        if (preg_match('/field_\d/', $name)) {
            list($type, $id) = explode("_", $name);
            $module = cms('module');
            if (!isset($module[$id])) return false;
            $name = $module[$id]['name'];
        }
        if (in_array($name, self::ALLOW_TYPE)) return true;
        $this->name = $name;
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
