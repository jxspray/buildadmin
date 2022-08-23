<?php

namespace app\web;

use app\BaseController;
use app\controller\Action;
use think\App;

class Base extends Action
{
    /**
     * 架构函数 取得模板对象实例
     * @access public
     */
    public function __construct(App $app)
    {
        parent::__construct($app);
        /*if (!S("STDK_version")) {
            $url = $_SERVER['SERVER_NAME'];
            $res = httpPost("http://api.jovo.site/api/auth/checkurl", ['url' => $url]); //效验域名权限
            $res = json_decode($res, true);
            if (isset($res) && $res['error'] != 0) {
                exit("请确认系统配置是否正确!");
            } else {
                S("STDK_version", $res, 432000); //记录缓存并放行，5天查一次
            }
        }*/

//        tag('action_begin', $this->config);
        //控制器初始化
        if (method_exists($this, '_initialize')) $this->_initialize();


    }


    /**
     * 魔术方法 有不存在的操作的时候执行
     * @access public
     * @param string $method 方法名
     * @param array $args 参数
     * @return mixed
     */
    public function __call($method, $args)
    {
        if (!$this->request->isAjax()) {
            if (method_exists($this, '_empty')) {
                // 如果定义了_empty操作 则调用
                $this->_empty($method, $args);
//            } elseif (file_exists_case(C('TEMPLATE_NAME'))) {
//                // 检查是否存在默认模版 如果有直接输出模版
//                $this->display();
            } elseif (function_exists('__hack_action')) {
                // hack 方式定义扩展操作
                __hack_action();
            } else {
                dump(404);
                die;
//                _404(L('_ERROR_ACTION_') . ':' . ACTION_NAME);
            }
        }
    }

}