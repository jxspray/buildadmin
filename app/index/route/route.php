<?php

use think\facade\Route;
// 规则
Route::pattern([
    "param"  => "[\w\-]+",
    "name"   => "[\w\-]+",
    "id"     => "\d+",
]);

$append["app"] = 'home';
$append["module"] = 'article';
$append["action"] = "catalog";
Route::rule("about", "action/index")->append(array_merge($append, ['rule' => 'about']));
Route::rule("about/:param", "action/index")->append($append);
Route::rule("/", "action/index")->append(['action' => 'index']);