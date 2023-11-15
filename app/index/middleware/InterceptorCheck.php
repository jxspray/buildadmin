<?php

declare (strict_types = 1);
namespace app\index\middleware;

class InterceptorCheck
{
    public function handle(\app\Request $request, \Closure $next)
    {
        $pathinfo = $request->pathinfo();
        // 拦截以cms、storage开头请求
        if (preg_match('/^(cms|storage)/', $pathinfo)) {
            abort(404, "资源不存在");
        }
        // 检查重定向后台地址
        if (preg_match('/^(sysjovo)/', $pathinfo) && $pathinfo != "sysjovo/") {
            header("location:/sysjovo/");
            exit();
        }

        // 下一步
        return $next($request);
    }
}
