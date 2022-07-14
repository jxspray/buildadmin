<?php
declare(strict_types=1);

namespace app\api\library\hangSign;

use app\api\library\AutoSign;
use app\api\library\SignCommon;
use think\Exception;

/**
 * 杂货百铺
 */
class Index extends SignCommon implements AutoSign
{
    protected $account = "jxspray";
    protected $password = "123456";

    /**
     * 初始化
     * @throws \Exception
     */
    public function __init()
    {
        // 初始化系统地址
        $this->getSystemUrl();
    }

    /**
     * 系统签到
     * @return void
     */
    public function sign()
    {
        // 登录
        $this->login();
        // 访问登录页
        $this->visitSign();
        // 执行登录
        $options = $this->options;
        $params = [];
        $res = $this->request->get("$this->siteUrl/user/ajax.php?act=qiandao", $params, $options);
        if ($this->getResponseBody($res, $data)) exit($data);
        exit(json_encode(['code' => -1, "返回内容有误"]));
    }

    /**
     * 平台登录
     * @return array
     */
    public function login(): array
    {
        $params = [
            'user' => request()->get("account") ?? $this->account,
            'pass' => request()->get("password") ?? $this->password
        ];
        $options = [
            CURLOPT_HEADER => 1
        ];
        $res = $this->request->post("$this->siteUrl/user/ajax.php?act=login", $params, $options);
        if ($this->getResponseBody($res, $data)) {
            $data = json_decode($data, true);
            if ($data['code'] == '0') {
                if (!$this->getResponseCookie($res, $this->cookies)) return ['code' => -1, "获取cookies失败"];
                $this->options = [
                    CURLOPT_COOKIE => $this->cookies
                ];
            }
            return $data;
        }
        return ['code' => -1, "返回内容有误"];
    }

    /**
     * 访问签到页（如不访问是无法签到的）
     * @return void
     */
    public function visitSign()
    {
        $params = [];
        $this->request->get("$this->siteUrl/user/qiandao.php", $params, $this->options);
    }

    /**
     * 获取响应体
     * @param $str
     * @param $data
     * @return false|mixed
     */
    private function getResponseBody($str, &$data = false)
    {
        preg_match('/\{(.*?)}/', $str, $matches);
        return $data = $matches[0] ?? false;
    }

    /**
     * 获取响应cookies
     * @param $str
     * @param $cookies
     * @return false|string
     */
    private function getResponseCookie($str, &$cookies)
    {
        preg_match_all('/^Set-Cookie: (.*?);/m', $str, $m);
        $cookies = implode(";", $m[1]);
        return $cookies ?? false;
    }

    /**
     * 根据入口地址获取系统地址
     * @param bool $force
     * @return void
     * @throws \Exception
     */
    private function getSystemUrl(bool $force = false): void
    {
        if ($force || !$this->redis->has("hangSiteUrl")) {
            $res = $this->request->get("http://9.gdjgll.com/?middle_info=u553fW3B");
            preg_match('/<a href="(.*?)"/', $res, $matches);
            $urlAdd = $matches[1] ?? "";
            if (!$urlAdd) throw new Exception("系统地址不存在");
            preg_match('/^http(s)?:\/\/(.*)\//U', $urlAdd, $siteUrl);
            $this->redis->set("hangSiteUrl", $siteUrl[2]);
        }
        $this->siteUrl = $this->redis->get("hangSiteUrl");
    }
}