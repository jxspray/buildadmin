<?php

namespace app\common\facade;

/**
 * Cms 门面类
 * @see \app\common\library\Cms
 * @method \think\Model getModel(string $moduleName) static 获取模型
 */
class Cms extends \think\Facade
{
    protected static function getFacadeClass(): string
    {
        return 'app\common\library\Cms';
    }
}