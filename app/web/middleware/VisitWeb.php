<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2021 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
declare (strict_types=1);

namespace app\web\middleware;

use Closure;
use think\Request;
use think\Response;
use think\facade\Config;

/**
 * 前端过滤器
 * 安全起见，只支持了配置中的域名
 */
class VisitWeb
{
    protected $header = [
    ];

    /**
     * 跨域请求检测
     * @access public
     * @param Request $request
     * @param Closure $next
     * @param array   $header
     * @return Response
     */
    public function handle($request, Closure $next, ?array $header = [])
    {
        die;
        return $next($request)->header($header);
    }
}
