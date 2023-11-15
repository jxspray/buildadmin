<?php
// +----------------------------------------------------------------------
// | OneKeyAdmin [ Believe that you can do better ]
// +----------------------------------------------------------------------
// | Copyright (c) 2020-2023 http://onekeyadmin.com All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: MUKE <513038996@qq.com>
// +----------------------------------------------------------------------
declare (strict_types = 1);

namespace app\index\middleware;

/**
 * 环境检测
 */
class AppCheck
{
    public function handle(\app\Request $request, \Closure $next)
    {
        // 路由信息
        $request->pathinfo = str_replace('.html', '', $request->pathinfo());

        $pathArr = explode('/', $request->pathinfo);
        foreach ($pathArr as $key => $val) {
            if (empty($val)) unset($pathArr[$key]);
        }
        $request->pathArr  = array_values($pathArr);
        $request->path     = empty($request->pathArr[0]) ? 'index' : $request->pathArr[0];
        // 绑定事件
        event('AppCheck', $request);
        // 下一步
        return $next($request);
    }
}
