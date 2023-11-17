<?php

use think\facade\Route;
dump(\think\facade\Filesystem::disk("minio")->fileSize("/a.jpg"));die;
// 配置后台访问
Route::rule("sysjovo/", "vue/index");
// ------------------------注意------------------------
// 1.访问地址不得在中间书写纯数字，数字只能写在末尾

$indexAppend = [
    'pattern' => 'home',
    'module' => 'index',
    'action' => 'index'
];
$append = [
    'pattern' => 'home',
];
/* 是否必要.html */
/** 栏目规则生成 */
$pathInfo = request()->pathinfo();
$catdir = "[\w^_]+";
if (!empty($pathInfo)) {
    $rule = [];
    $arr = [];
    foreach (explode("/", $pathInfo) as $value) {
        if (!empty($value)) {
            $rule[] = "[\w^_]+";
            $arr[] = $value;
        }
    }
    if (count($rule) > 0) {
        $catdir = implode("\/", $rule);
        $id = array_pop($arr);
        if (count($x = explode(".", $id)) > 1) $id = $x[0];
        $append['module'] = 'urlRule';
        if (is_numeric($id)) {
            $append['action'] = 'info';
            $append['catdir'] = implode("/", $arr);
            $append['id'] = $id;
        } else if (count($y = explode("-", $id)) > 1){
            $append['action'] = 'catalog';
            $append['page'] = $y[1];
        } else {
            $append['action'] = 'catalog';
        }
    }
}

// 规则
Route::pattern([
    "catdir" => $catdir,
    "param" => "[\w\-]+",
    "name" => "[\w\-]+",
    "dirid" => "\d+",
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
/* 首页访问，需要放在第一个 */
Route::rule("index", "action/index")->append($indexAppend)->middleware($middleware);

/* 内页 */
//Route::rule(":catdir", "action/index")->append($append)->middleware($middleware);

/* 默认首页，需要放在末尾 */
Route::rule("/", "action/index")->append($indexAppend)->middleware($middleware);
Route::miss(function() {
    return '404 Not Found!';
});
