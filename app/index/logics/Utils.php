<?php

namespace app\index\logics;


/**
 * 当前主题
 */
function theme(): string
{
    if (empty(input('theme'))) {
        return empty(env('app_theme')) ? config('app.theme') : env('app_theme');
    } else {
        return input('theme');
    }
}
/**
 * 获取index应用url
 * @Author jxspray@163.com
 * @param string $url 链接
 * @param array $vars 参数
 * @param bool $theme
 * @return string
 */
function index_url(string $url = '', array $vars = [], bool $theme = true): string
{
    $url = empty($url) || $url == 'index' ? '' : '/' . $url . '.html';
    if ($theme && ! empty(input('theme'))) {
        $vars['theme'] = theme();
    }
    if (empty($vars['lang']) && ! empty(input('lang'))) {
        $vars['lang'] = input('lang');
    }
    $param = "";
    $index = 0;
    foreach ($vars as $key => $val) {
        $str = $index === 0 ? '?' : '&';
        $param .= $str . $key . '=' . $val;
        $index++;
    }
    return request()->domain() . $url . $param;
}
class Utils
{
    /**
     * 指定链接
     * @Author jxspray@163.com
     * @param array $link 自定义参数
     * @param bool $theme
     * @return string
     */
    public static function appoint(array $link, bool $theme = true): string
    {
        $url = "";
        if (! empty($link)) {
            switch ($link['type']) {
                case '1':
                    if (strstr($link['value'][1]['url'], 'http') === false) {
                        $url = index_url($link['value'][1]['url'], [], $theme);
                    } else {
                        $url = $link['value'][1]['url'];
                    }
                    break;
                case '2':
                    $url = self::getSingleUrl($link['value'][2]['details'], $theme);
                    break;
                case '3':
                    $id = $link['value'][3]['catalog']['id'];
                    if (! empty(request()->catalogList)) {
                        $catalog = [];
                        foreach (request()->catalogList as $key => $value) {
                            if ($value['id'] == $id) $catalog = $value;
                        }
                    } else {
                        // 只有获取分类时，才会重新加载
                        $catalog = \app\index\model\Catalog::where('id', $id)->find();
                        $catalog = $catalog ? $catalog->toArray() : [];
                    }
                    if (! empty($catalog)) {
                        if ($catalog['links_type'] === 1) {
                            $url = self::appoint(json_decode($catalog['links_value'],true), $theme);
                        } else {
                            $anchor = empty($link['value'][3]['anchor']) ? '' : $link['value'][3]['anchor'];
                            $url = self::catalog($catalog, $theme).$anchor;
                        }
                    }
                    break;
            }
        }
        return $url;
    }
}