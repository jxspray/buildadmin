<?php

use think\facade\Route;
// 配置后台访问
Route::rule("sysjovo/", "vue/index");
// ------------------------注意------------------------
// 1.访问地址不得在中间书写纯数字，数字只能写在末尾

// 规则
Route::pattern([
    "param" => "[\w\-]+",
    "name" => "[\w\-]+",
    "dirid" => "\d+",
    "page" => "\d+",
    "id" => "\d+",
]);
// 配置cms中间件
$middleware = ([
    // 分类检测
    app\index\middleware\CatalogCheck::class,
    // 配置检测
    app\index\middleware\ConfigCheck::class,
    // TDK检测
    app\index\middleware\TdkCheck::class,
]);


$infoAppend = [
    'pattern' => 'home',
    'module' => 'urlRule',
    'action' => 'info'
];
// 模型路由访问
foreach (cms("module") as $module) {
    if ($module['rule']) Route::get("{$module['rule']}/:id", "action/index")->append(array_merge($infoAppend, ['path' => $module['rule']]))->middleware($middleware);
}
$catalogAppend = [
    'pattern' => 'home',
    'module' => 'urlRule',
    'action' => 'catalog'
];

$indexAppend = [
    'pattern' => 'home',
    'module' => 'index',
    'action' => 'index'
];
// 栏目路由访问
foreach (cms("catalog") as $catalog) {
    if ($catalog['seo_url']) {
        $catalogAppend['catid'] = $catalog['id'];
        $catalogAppend['module_id'] = $catalog['module_id'];
        $catalogAppend['path'] = $catalog['seo_url'];
        if ($catalog['seo_url'] === 'index') {
            $indexAppend['catid'] = $catalog['id'];
            $indexAppend['path'] = $catalog['seo_url'];
            Route::get("index", "action/index")->append($indexAppend)->middleware($middleware);
        } else {
            Route::get($catalog['seo_url'], "action/index")->append($catalogAppend)->middleware($middleware);
            Route::get("{$catalog['seo_url']}-:page", "action/index")->append($catalogAppend)->middleware($middleware);
            Route::get("{$catalog['seo_url']}/:id", "action/index")->append($infoAppend)->middleware($middleware);
        }
    }
}

/* 默认首页，需要放在末尾 */

/* 首页访问，需要放在第一个 */
//Route::get("index", "action/index")->append($indexAppend)->middleware($middleware);
Route::miss(function() {
    return '404 Not Found!';
});
