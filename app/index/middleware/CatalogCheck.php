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

use app\index\model\web\Catalog;
use app\Request;
use ba\cms\utils\Tree;

/**
 * 分类检查
 */
class CatalogCheck
{
    public function handle(Request $request, \Closure $next)
    {
        // 所有分类菜单
        $append  = ['url', 'route'];
        $where[] = ['status', '=', 1];
//        $where[] = ['theme', '=', theme()];
        $catalogList = Catalog::where($where)->order('weigh','desc')
//            ->cache('catalog_'.theme())
                ->cache()
            ->append($append)->select()->toArray();
        $request->catalogList = array_combine(array_column($catalogList, 'id'), $catalogList);
        // 头部底部菜单
        $catalogHeader = [];
        $catalogFooter = [];
        foreach ($request->catalogList as $val) {
            if ($request->isMobile() && $val['mobile'] === 0) continue;
                switch ($val['show']) {
                    case 1:
                        $catalogHeader[] = $val;
                        $catalogFooter[] = $val;
                        break;
                    case 2:
                        $catalogHeader[] = $val;
                        break;
                    case 3:
                        $catalogFooter[] = $val;
                        break;
                }
        }
        $header = new Tree($catalogHeader);
        $footer = new Tree($catalogFooter);
        $request->catalogHeader = $header->leaf(0);
        $request->catalogFooter = $footer->leaf(0);
        // 当前分类
        $catalog = [];
        $module = $request->param("module", "index");
        if ($module == "moduleRule") {
            // 获取排序值最大的栏目 TODO 计划将在模型内绑定默认栏目
            $catalog = Catalog::where("module_id", $request->param("module_id"))->order("weigh DESC")->find();
            // 指定链接
            if ($catalog['links_type'] == 1) {
                return redirect($catalog['url']);
            }
        } else {
            $path = $request->param("path", "index");
            foreach ($request->catalogList as $val) {
                if ($val['seo_url'] == $path || $val['id'] == $path) {
                    $catalog = $val;
                    // 指定链接
                    if ($catalog['links_type'] == 1) {
                        return redirect($catalog['url']);
                    }
                }
            }
        }
        // 站内链接
        if (empty($catalog)) {
            foreach ($request->catalogList as $key => $val) {
                if ($val['links_type'] == 1) {
                    if (str_contains($val['url'], $request->domain() . '/' . $path)) {
                        $catalog = $val;
                    }
                }
            }
        }
        // 默认信息
        if (empty($catalog)) {
            $catalog = [
                'id'              => '',
                'pid'             => '0',
                'title'           => '',
                'description'     => '',
                'template_index'  => '',
                'template_info'   => '',
                'seo_url'         => '',
                'seo_title'       => '',
                'seo_keywords'    => '',
                'seo_description' => '',
                'catdir'          => '',
                'pdir'            => 1,
                'weigh'           => 0,
                'module'          => '',
                'module_id'       => '',
                'field'           => [],
                'status'          => 1,
//                'mobile'          => 1,
//                'level1'          => '',
//                'theme'           => theme(),
//                'group_id'        => [],
                'show'            => 0,
                'language'        => $request->lang,
                'route'           => $request->pathinfo(),
            ];
        }
        // 当前面包屑
        $catalogTree = new Tree($request->catalogList);
        $request->crumbs = !empty($catalog['id']) ? $catalogTree->navi($catalog['id']) : [];
        // 分类等级
        foreach ($request->crumbs as $key => $val) {
            $level = 'level' . ($key + 1);
            $catalog[$level] = $val['id'];
        }
        // 当前分类
        $request->catalog = $catalog;
        // 下一步
        return $next($request);
    }
}
