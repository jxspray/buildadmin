<?php

namespace app\api\library\jjSign;

use app\api\library\AutoSign;
use app\api\library\SignCommon;

/**
 * 掘金
 */
class Index extends SignCommon implements AutoSign
{
    protected $getParam = [];
    protected $siteUrl = "https://api.juejin.cn/growth_api/v1";
    protected $cookies = 'MONITOR_WEB_ID=12994e89-859d-43eb-bc8f-d8cc7b6ed6a8; _ga=GA1.2.1436041439.1641518525; __tea_cookie_tokens_2608=%7B%22web_id%22%3A%227050268317831890473%22%2C%22ssid%22%3A%224f8e254f-4a2e-4d85-b4dd-0b170732139e%22%2C%22user_unique_id%22%3A%227050268317831890473%22%2C%22timestamp%22%3A1641518524700%7D; n_mh=dnGOd8mEyLd_6037NxGukrgvBSnh2Dj-rx_38PNeqvQ; _tea_utm_cache_2608={"utm_source":"gold_browser_extension"}; passport_csrf_token=0ca82547da2dbc5ceac9a99019d8142d; passport_csrf_token_default=0ca82547da2dbc5ceac9a99019d8142d; sid_guard=8f483a6e900dbbd9ac90f8eb8d0586f0|1653700448|31536000|Sun,+28-May-2023+01:14:08+GMT; uid_tt=ed97e56864d815894b369fac9ae91127; uid_tt_ss=ed97e56864d815894b369fac9ae91127; sid_tt=8f483a6e900dbbd9ac90f8eb8d0586f0; sessionid=8f483a6e900dbbd9ac90f8eb8d0586f0; sessionid_ss=8f483a6e900dbbd9ac90f8eb8d0586f0; sid_ucp_v1=1.0.0-KGEwNDlhZTlmZDhmZWYyYTViYmM2YjA1ODhlNzMzYTRiZjUzMWI4M2UKFgiXh_D5v4ziAxDg7sWUBhiwFDgIQAsaAmxmIiA4ZjQ4M2E2ZTkwMGRiYmQ5YWM5MGY4ZWI4ZDA1ODZmMA; ssid_ucp_v1=1.0.0-KGEwNDlhZTlmZDhmZWYyYTViYmM2YjA1ODhlNzMzYTRiZjUzMWI4M2UKFgiXh_D5v4ziAxDg7sWUBhiwFDgIQAsaAmxmIiA4ZjQ4M2E2ZTkwMGRiYmQ5YWM5MGY4ZWI4ZDA1ODZmMA; _gid=GA1.2.214625474.1657075028';
    protected $queryStr = "";

    /**
     * 初始化
     * @return array|void
     */
    public function __init()
    {
        $this->login();
        if (!$this->getParam) return ['code' => -1, ',msg' => "缺少必要参数"];
        $this->queryStr = "?aid={$this->getParam['aid']}&uuid={$this->getParam['uuid']}";
    }

    /**
     * @return array
     */
    public function login(): array
    {
        $this->getParam = [
            'aid' => request()->get("aid") ?? 2608,
            'uuid' => request()->get("uuid") ?? '7050268317831890473'
        ];
        $this->options = [
            CURLOPT_COOKIE => request()->get("cookies") ?? $this->cookies
        ];
        return ['code' => 0, "msg" => "返回参数成功"];
    }

    /**
     * 签到
     * @return mixed
     */
    public function sign()
    {
        $res = $this->request->post("$this->siteUrl/check_in{$this->queryStr}", [], $this->options);
        return json_decode($res, true);
    }

    /**
     * 沾福气
     * @return mixed
     */
    public function lucky(){
        $params = [
            'lottery_history_id' => "7056938122860298243"
        ];
        $res = $this->request->post("$this->siteUrl/lottery_lucky/dip_lucky{$this->queryStr}", $params, $this->options);
        return json_decode($res, true);
    }

    /**
     * 抽奖
     * @return mixed
     */
    public function lottery(){
        $res = $this->request->post("$this->siteUrl/lottery/draw{$this->queryStr}", [], $this->options);
        return json_decode($res, true);
    }
}