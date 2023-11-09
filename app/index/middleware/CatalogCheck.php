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
use ba\cms\utils\Tree;

/**
 * 分类检查
 */
class CatalogCheck
{
    public function handle($request, \Closure $next)
    {
        // 所有分类菜单
        $append  = ['url', 'route'];
        $where[] = ['status', '=', 1];
//        $where[] = ['theme', '=', theme()];
        $catalogList = Catalog::where($where)->order('weigh','desc')
//            ->cache('catalog_'.theme())
                ->cache(true, config("cms.cache."))
            ->append($append)->select()->toArray();
        $request->catalogList = array_combine(array_column($catalogList, 'id'), $catalogList);
        // 头部底部菜单
        $catalogHeader = [];
        $catalogFooter = [];
        foreach ($request->catalogList as $key => $val) {
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
        // 分类路由
        $request->catalogRoute = count($request->pathArr) === 1 || $request->path === 'index';
        // 分页路由
        $request->singleRoute  = count($request->pathArr) === 2;
        // 详情路由
        $request->PageRoute    = in_array('page', $request->pathArr) && isset($request->pathArr[2]) && is_numeric($request->pathArr[2]);
        // 当前分类
        $catalog = [];
        foreach ($request->catalogList as $key => $val) {
            if ($val['seo_url'] == $request->path || $val['id'] == $request->path) {
                if ($request->catalogRoute || $request->singleRoute || $request->PageRoute) {
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
                    if (str_contains($val['url'], $request->domain() . '/' . implode('/', $request->pathArr))) {
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
                'route'           => $request->pathinfo,
            ];
        }
        // 当前面包屑
        $catalogTree = new Tree($request->catalogList);
        $request->crumbs = $catalogTree->navi($catalog['id']);
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