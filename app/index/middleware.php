<?php
// +----------------------------------------------------------------------
// | 全局中间件定义文件
// +----------------------------------------------------------------------

return [
    // 环境检测
    app\index\middleware\AppCheck::class,
    // 分类检测
    app\index\middleware\CatalogCheck::class,
    // 配置检测
    app\index\middleware\ConfigCheck::class,
    // TDK检测
    app\index\middleware\TdkCheck::class,
];
