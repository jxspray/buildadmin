<?php
declare (strict_types = 1);

namespace app\index\controller\web;

use app\index\model\web\Config;
use app\index\model\web\Content;

class Base extends \app\index\controller\Action
{
    protected string $terminal;
    protected array $categorys;

    public function __construct(\think\App $app)
    {
        parent::__construct($app);
        // 设置终端
        $this->settingTerminal();
        $this->categorys = cms('catalog');
        // 设置语言数据
        $this->settingLangData();
//        $this->assign($this->Config);

        foreach ((new \app\index\model\web\Config)->column('value', 'name') as $name => $item) {
            $name = ucfirst($name);
            $this->assign("init{$name}", json_decode($item));
        }
        $this->assign('Config', json_decode(json_encode(['version' => '0.0.1'])));
        $this->assign('Categorys', $this->categorys);
    }

    public function catalog($catid = '', $module = ''): ?string
    {
        if (empty($catid)) $catid = $this->request->param("catid", '', 'intval');

        if (!$catid) abort(404);
        $cat = $this->categorys[$catid];
        $cat['catid'] = $catid;
        $cat['catname'] = $cat['title'];
        unset($cat['id'], $cat['title']);

        // 加载列表
        $lists = Content::getInstance($cat['module'])->where('catid', $catid)->paginate(10);
        $this->assign('list', $lists->items());
        $this->assign('pages', $lists->render());
        $this->assign($cat);
        $this->settingSEOData();
        return $this->fetch("{$module}/{$cat['template_show']}");
    }

    public function single($catid = '', $module = ''): ?string
    {
        if (empty($catid)) $catid = $this->request->param("catid", '', 'intval');

        if (!$catid) abort(404);
        $cat = $this->categorys[$catid];
        $cat['catid'] = $catid;
        $cat['catname'] = $cat['title'];
        unset($cat['id'], $cat['title']);
        $this->assign($cat);
        $this->settingSEOData();
        return $this->fetch("{$module}/{$cat['template_show']}");
    }

    public function info($catid = '', $module = ''): ?string
    {
        if (empty($catid)) $catid = $this->request->param("catid", '', 'intval');
        $id = $this->request->param("id", '', 'intval');

        if (!$catid) abort(404);
        $cat = $this->categorys[$catid];
        $cat['catid'] = $catid;
        $cat['catname'] = $cat['title'];
        unset($cat['id'], $cat['title']);
        $this->assign($cat);
        $this->settingSEOData();
        $this->assign(getInfo($module, $id));
        return $this->fetch("{$module}/{$cat['template_show']}");
    }

    /**
     * 设置数据终端  Home/Wap
     * @return void
     */
    private function settingTerminal(): void
    {
        $terminal = $this->checkTerminal(); // 检测终端
        $this->pattern = in_array($terminal, ['wap', 'xcx']) ? 'wap' : 'home';
        $this->terminal = $terminal;
    }

    private function checkTerminal(): string
    {
        $terminal = 'home'; // 默认为PC端
        if (check_mobile()) $terminal = 'wap'; // 如果是手机端设备访问，则设置为手机端
//        else if ($_SERVER['SERVER_NAME'] == $this->Config['wap_url']) $terminal = 'wap'; // 如果是手机端域名访问，则设置为手机端
//        elseif (cookie('phone') == 1) $terminal = 'wap'; // 如果是手机端标识COOKIE存在，则为手机端访问
        return $terminal;
    }
    public function settingSEOData(array|string $title = [], array|string $keywords = [], array|string $description = [], string $icoImage = ''): void
    {
        // 移除空值
        $title = array_filter($title);
        $keywords = array_filter($keywords);
        $description = array_filter($description);

        $this->assign('seoTitle', $title[0]??'SEO标题');
        $this->assign('seoKeywords', $keywords[0]??'SEO关键词');
        $this->assign('seoDescription', $description[0]??'SEO描述');
        $this->assign('icoImage', $icoImage);
    }

    /**
     * 设置语言
     */
    public function settingLangData()
    {
//        $this->Config = F('Config_' . LANG_NAME); // 获取站点配置
//        $this->categorys = F('Category_' . LANG_NAME); // 获取栏目
//        cookie('think_language', LANG_NAME); // 设置语言
//        define('TABLE_CATEGORY', 'category' . (LANG_NAME != 'cn' ? '_' . LANG_NAME : ''));
//
//        // 通用参数独立设置
//        foreach ($this->categorys as $category) {
//            $sysparam = trim($category['sysparam']);
//            if ($sysparam) {
//                $cateAll[$sysparam . 'Id'] = $category['id'];
//                $cateAll[$sysparam . 'Url'] = $category['url'];
//                $cateAll[$sysparam . 'Name'] = $category['catname'];
//                $cateAll[$sysparam . 'SubName'] = $category['titlesub'];
//                $cateAll[$sysparam . 'Thumb'] = $category['thumb'];
//                $cateAll[$sysparam . 'Banner'] = $this->getTerminalValue($category, 'banner');
//                $cateAll[$sysparam . 'Remark'] = $category['remark'];
//                $cateAll[$sysparam . 'Module'] = $category['module'];
//            }
//        }
//        $this->assign($cateAll);
    }

    // 前端模板设置  Home/Defalut或者Home/En或者Wap/En
    public function jovo_template_path()
    {
        // 终端模板切换
        $path = strtr(THEME_PATH, array('home' => $this->app));
        // 语言模板判断
        if (LANG_NAME != 'cn') $path = strtr($path, array('Default' => ucfirst(LANG_NAME)));
        return $this->template = $path; // 设置模板目录
    }
}
