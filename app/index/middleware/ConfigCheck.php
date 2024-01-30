<?php 
// +----------------------------------------------------------------------
// | OneKeyAdmin [ Believe that you can do better ]
// +----------------------------------------------------------------------
// | Copyright (c) 2020-2023 http://onekeyadmin.com All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: MUKE <513038996@qq.com>
// +----------------------------------------------------------------------
declare (strict_types = 1);

namespace app\index\middleware;

//use app\index\addons\Url;
//use app\index\model\Themes;
//use app\index\model\Config;
use app\Request;
use think\facade\View;
use function ba\cms\utils\index_url;

/**
 * 配置检测
 */
class ConfigCheck
{
    public function handle($request, \Closure $next)
    {
        // 基础信息
        $cms = \app\index\model\web\Config::load("basic", "cms")->value;
        $seo = \app\index\model\web\Config::load("basic", "seo")->value;
        $block = \app\index\model\web\Config::load("block", "base")->value;

        $request->system   = $cms;
        $request->block   = $block;
        $request->seo   = $seo;
        $request->label    = [];
        // 页面配置
        $response = $next($request);
        if ($request->isGet()) {
//            $request->htmlCheck = $this->html($request);
//            dump($request->htmlCheck);die;
//            View::assign("htmlCheck", $this->html($request));
//            $content = str_replace('<head>', '<head>' . $this->html($request), $response->getContent());
//            $response->content($content);
            // 绑定事件
            event('HtmlCheck', $response);
        }
        // 下一步
        return $response;
    }

    /**
     * 头部渲染
     * @param Request $request 请求参数
     * @Author: jxspray@163.com
     * @Date: 2023/11/6
     * @Time: 10:28
     * @return string
     */
    public function html(Request $request): string
    {
        $system = index_url("controller/method");
        $home = index_url("");
        return <<<HTML
<script type="text/javascript">
function index_url(url = "", parameter = {}) {
    let system = "$system";
    let home   = "$home";
    let link   = url == "" || url == "index" ? home : system.replace("controller/method",url);
    let param  = "";
    let index  = 0;
    for(key in parameter){
        str    = link.indexOf("?") == -1 && index == 0 ? "?" : "&";
        param += str + key + "=" + parameter[key];
        index++;
    }
    return link + param;
}
</script>
HTML;
    }
}