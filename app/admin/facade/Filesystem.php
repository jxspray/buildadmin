<?php

namespace app\admin\facade;

use think\Facade;

/**
 * @see \ba\filesystem\Filesystem
 * @mixin \ba\filesystem\Filesystem
 */
class Filesystem extends Facade
{
    protected static function getFacadeClass()
    {
        return 'ba\filesystem\Filesystem';
    }
}
