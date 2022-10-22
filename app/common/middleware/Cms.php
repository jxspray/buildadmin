<?php

namespace app\common\middleware;

use Closure;
use think\facade\Config;
use app\admin\model\AdminLog as AdminLogModel;

class Cms
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);
        return $response;
    }
}
