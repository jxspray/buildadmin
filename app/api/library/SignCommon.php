<?php
declare(strict_types=1);

namespace app\api\library;


use Exception;
use think\cache\driver\Redis;

abstract class SignCommon
{
    protected $siteUrl;
    protected $request;
    protected $redis;
    protected $cookies;
    protected $options = [];

    /**
     * @throws Exception
     */
    public function __construct()
    {
        $this->redis = new Redis();
        $this->request = new Http();
        $this->__init();
    }

    //随机IP

    public function Rand_IP()
    {

        $ip2id = round(rand(600000, 2550000) / 10000); //第一种方法，直接生成

        $ip3id = round(rand(600000, 2550000) / 10000);

        $ip4id = round(rand(600000, 2550000) / 10000);

        //下面是第二种方法，在以下数据中随机抽取

        $arr_1 = array("218", "218", "66", "66", "218", "218", "60", "60", "202", "204", "66", "66", "66", "59", "61", "60", "222", "221", "66", "59", "60", "60", "66", "218", "218", "62", "63", "64", "66", "66", "122", "211");

        $randarr = mt_rand(0, count($arr_1) - 1);

        $ip1id = $arr_1[$randarr];

        return $ip1id . "." . $ip2id . "." . $ip3id . "." . $ip4id;

    }
}