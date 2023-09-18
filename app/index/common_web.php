<?php
// 这是系统自动生成的公共文件

/**
 * 检测是否使用手机访问
 * @access public
 * @return bool
 */
function check_mobile(): bool
{
    // 如果有HTTP_X_WAP_PROFILE则一定是移动设备
    if (isset($_SERVER['HTTP_X_WAP_PROFILE'])) return true;


    //此条摘自TPM智能切换模板引擎，适合TPM开发
    if (isset($_SERVER['HTTP_CLIENT']) && 'PhoneClient' == $_SERVER['HTTP_CLIENT']) return true;

    //如果via信息含有wap则一定是移动设备,部分服务商会屏蔽该信息，加了CDN会有问题，判断不到手机
    if (isset($_SERVER['HTTP_VIA'])) return (bool) stristr($_SERVER['HTTP_VIA'], 'wap'); //找不到为false,否则为true
    //判断手机发送的客户端标志,兼容性有待提高
    if (isset($_SERVER['HTTP_USER_AGENT'])) {
        $clientKeywords = array(
            'nokia', 'sony', 'ericsson', 'mot', 'samsung', 'htc', 'sgh', 'lg', 'sharp', 'sie-', 'philips', 'panasonic', 'alcatel', 'lenovo', 'iphone', 'ipod', 'blackberry', 'meizu', 'android', 'netfront', 'symbian', 'ucweb', 'windowsce', 'palm', 'operamini', 'operamobi', 'openwave', 'nexusone', 'cldc', 'midp', 'wap', 'mobile'
        );
        //从HTTP_USER_AGENT中查找手机浏览器的关键字
        if (preg_match("/(" . implode('|', $clientKeywords) . ")/i", strtolower($_SERVER['HTTP_USER_AGENT']))) return true;
    }
    //协议法，因为有可能不准确，放到最后判断
    if (isset($_SERVER['HTTP_ACCEPT'])) {
        // 如果只支持wml并且不支持html那一定是移动设备
        // 如果支持wml和html但是wml在html之前则是移动设备
        if (
            (strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') !== false)
            &&
            (strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false || (strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') < strpos($_SERVER['HTTP_ACCEPT'], 'text/html')))) {
            return true;
        }
    }
    return false;
}


if (!function_exists("cms")) {
    /**
     * @param string $name
     * @param string $type
     * @return array
     */
    function cms(string $name, string $type = 'cache'): array|bool
    {
        switch ($type) {
            case 'cache':
                if (\app\index\logics\CmsLogic::getInstance()->getType($name))
                    return \app\index\logics\handler\CmsCache::getInstance($name)->checkCache()->cache();
                return false;
        }
        return false;
    }
}

if (!function_exists('getSlides')) {
    /**
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\db\exception\DbException
     */
    function getSlides(array|int $where = [], $limit = NULL): \app\index\model\web\Slide
    {
        $res = (new app\index\model\web\Slide)->getInfo($where);
        if (!$res) abort(500, "幻灯片不存在");
        if ($limit) $res->list()->limit($limit)->select();
        $res->list;
        return $res;
    }
}

if (!function_exists('getBlock')) {
    /**
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\db\exception\DbException
     */
    function getBlock(string $name)
    {
        $res = app\index\model\web\Config::load($name);
        if (!$res) abort(500, "配置不存在");
        return json_decode($res->value);
    }
}

if (!function_exists('getCategory')) {
    /**
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     */
    function getCategorys($catids, $limit = '', $where = array(), $order = '')
    {
//        if (!isset($where['ismenu'])) $where['ismenu'] = 1;
        $where['pid'] = ['in', "$catids"];
//        $order = $order ? "{$order}, listorder desc,id desc" : "listorder desc,id desc";
        $data = (new \app\index\model\web\Catalog)->where("pid", $catids)->select();
//        if ($data) {
//            $categorys = F('Category_' . LANG_NAME);
//            foreach ($data as &$datum) {
//                $datum = $categorys[$datum['id']];
//            }
//        }
        return $data;
    }
}