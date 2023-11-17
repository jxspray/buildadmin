<?php

declare(strict_types=1);

namespace ba\filesystem;

use InvalidArgumentException;
use think\helper\Arr;
use think\Manager;

class Filesystem extends Manager
{
    protected $namespace = '\\ba\\filesystem\\driver\\';

    /**
     * @param null|string $name
     * @return Driver
     */
    public function disk(string $name = null): Driver
    {
        return $this->driver($name);
    }

    /**
     * @param null|string $name
     * @return Driver
     */
    public function cloud(string $name = null): Driver
    {
        return $this->driver($name);
    }


    protected function resolveType(string $name): array
    {
        return $this->getDiskConfig($name, 'type', 'local');
    }

    protected function resolveConfig(string $name): array
    {
        return $this->getDiskConfig($name);
    }

    /**
     * 获取缓存配置
     * @access public
     * @param null|string $name 名称
     * @param mixed $default 默认值
     * @return mixed
     */
    public function getConfig(string $name = null, $default = null): mixed
    {
        if (!is_null($name)) {
            return $this->app->config->get('filesystem.' . $name, $default);
        }

        return $this->app->config->get('filesystem');
    }

    /**
     * 获取磁盘配置
     * @param string $disk
     * @param null $name
     * @param null $default
     * @return array
     */
    public function getDiskConfig($disk, $name = null, $default = null): array
    {
        if ($config = $this->getConfig("disks.{$disk}")) {
            return Arr::get($config, $name, $default);
        }

        throw new InvalidArgumentException("Disk [$disk] not found.");
    }

    /**
     * 默认驱动
     * @return string|null
     */
    public function getDefaultDriver(): ?string
    {
        return $this->getConfig('default');
    }

    /**
     * 动态调用
     * @param string $method
     * @param array $parameters
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        return $this->driver()->$method(...$parameters);
    }
}
