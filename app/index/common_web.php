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
    function cms($name, $type = 'cache')
    {
        switch ($type) {
            case 'cache':
                $typeItem = \app\index\logics\CmsLogic::getInstance()->getTypeItem();
                $cmsCache = \app\index\logics\handler\CmsCache::getInstance($name);
                if ($typeItem->setModule($name) && in_array($name, $typeItem->getType())) return $cmsCache->checkCache()->cache();
                return false;
        }
    }
}