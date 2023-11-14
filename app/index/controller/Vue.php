<?php

namespace app\index\controller;

class Vue extends \app\BaseController
{
    public function index(): string
    {
        $config = json_encode(["jovoAccount" => "hnjovo"]);
        $buildConfig = <<<JS
var buildconfig = $config;
console.log(buildconfig);
JS;
        return \think\facade\View::fetch(public_path() . "/index.html", ["buildconfig" => $buildConfig]);
    }

    public function indexjump() {
        header("location:/sysjovo/");
        exit();
    }

    public function error() {
        echo 999;die;
    }
}
