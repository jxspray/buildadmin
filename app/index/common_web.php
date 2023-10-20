<?php
// 这是系统自动生成的公共文件

if (!function_exists("str_cut")) {
//字符串截取
    function str_cut($sourcestr, $cutlength, $suffix = '...')
    {
        $str_length = strlen($sourcestr);
        if ($str_length <= $cutlength) {
            return $sourcestr;
        }
        $returnstr = '';
        $n = $i = $noc = 0;
        while ($n < $str_length) {
            $t = ord($sourcestr[$n]);
            if ($t == 9 || $t == 10 || (32 <= $t && $t <= 126)) {
                $i = 1;
                $n++;
                $noc++;
            } elseif (194 <= $t && $t <= 223) {
                $i = 2;
                $n += 2;
                $noc += 2;
            } elseif (224 <= $t && $t <= 239) {
                $i = 3;
                $n += 3;
                $noc += 2;
            } elseif (240 <= $t && $t <= 247) {
                $i = 4;
                $n += 4;
                $noc += 2;
            } elseif (248 <= $t && $t <= 251) {
                $i = 5;
                $n += 5;
                $noc += 2;
            } elseif ($t == 252 || $t == 253) {
                $i = 6;
                $n += 6;
                $noc += 2;
            } else {
                $n++;
            }
            if ($noc >= $cutlength) {
                break;
            }
        }
        if ($noc > $cutlength) {
            $n -= $i;
        }
        $returnstr = substr($sourcestr, 0, $n);


        if (substr($sourcestr, $n, 6)) {
            $returnstr = $returnstr . $suffix; //超过长度时在尾处加上省略号
        }
        return $returnstr;
    }
}
/**
 * 检测是否使用手机访问
 * @access public
 * @return bool
 */
if (!function_exists("check_mobile")) {
    function check_mobile(): bool
    {
        // 如果有HTTP_X_WAP_PROFILE则一定是移动设备
        if (isset($_SERVER['HTTP_X_WAP_PROFILE'])) return true;


        //此条摘自TPM智能切换模板引擎，适合TPM开发
        if (isset($_SERVER['HTTP_CLIENT']) && 'PhoneClient' == $_SERVER['HTTP_CLIENT']) return true;

        //如果via信息含有wap则一定是移动设备,部分服务商会屏蔽该信息，加了CDN会有问题，判断不到手机
        if (isset($_SERVER['HTTP_VIA'])) return (bool)stristr($_SERVER['HTTP_VIA'], 'wap'); //找不到为false,否则为true
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

if (!function_exists('getLinks')) {
    /**
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\db\exception\DbException
     */
    function getLinks(array|int $where = [], $limit = NULL)
    {
        $res = (new app\index\model\web\Link)->getList($where);
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
    function getCategorys($catids, $limit = '', $where = array(), $order = ''): array|\think\Collection
    {
        $where['pid'] = ['in', "$catids"];
        $data = (new \app\index\model\web\Catalog)->where("pid", $catids)->order("weigh DESC")->select();
        return $data;
    }
}

if (!function_exists('getData')) {
    /**
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     */
    function getData($table, $where = array(), $limit = '', $order = 0, $field = '*', $gorup = ''): array|\think\Collection
    {
        $data = \app\index\model\web\Content::getInstance($table)->select();
        return $data;
    }
}

if (!function_exists('getInfo')) {
    /**
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     */
    function getInfo($table, array | int $where = array(), $field = '*'): array|\think\Collection
    {
        $data = \app\index\model\web\Content::getInstance($table)->find($where);
        return $data;
    }
}
