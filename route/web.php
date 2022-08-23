<?php

use think\facade\Route;

Route::get("/", 'Action/index');
Route::get(":a", 'Action/index');
///* 访问详情页 */
//Route::group(function() {
//    Route::get(':blog/:id', 'Action/index');
//    Route::get(':user/:name', 'Action/index');
//})->ext('html')->pattern(['id' => '\d+']);