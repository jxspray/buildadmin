<?php

namespace modules\vuerouter;

use Throwable;
use app\common\library\Menu;
use app\admin\model\AdminRule;

class Vuerouter
{
    /**
     * 安装
     * @throws Throwable
     */
    public function install(): void
    {
        $examplesMenu = AdminRule::where('name', 'examples')->value('id');
        if (!$examplesMenu) {
            $menu = [
                [
                    'type'      => 'menu_dir',
                    'title'     => '开发示例',
                    'name'      => 'examples',
                    'path'      => 'examples',
                    'icon'      => 'fa fa-code',
                    'menu_type' => 'tab',
                ]
            ];
            Menu::create($menu);
            $examplesMenu = AdminRule::where('name', 'examples')->value('id');
        }

        $menu = [
            [
                'type'      => 'menu',
                'title'     => '前端路由导航示例',
                'name'      => 'examples/vueRouter',
                'path'      => 'examples/vueRouter',
                'icon'      => 'fa fa-file-code-o',
                'menu_type' => 'tab',
                'component' => '/src/views/backend/examples/vueRouter.vue',
                'keepalive' => '1',
                'pid'       => $examplesMenu,
            ]
        ];
        Menu::create($menu);
    }

    /**
     * 卸载
     * @throws Throwable
     */
    public function uninstall(): void
    {
        Menu::delete('examples/vueRouter', true);
    }

    /**
     * 启用
     * @throws Throwable
     */
    public function enable(): void
    {
        Menu::enable('examples/vueRouter');
    }

    /**
     * 禁用
     * @throws Throwable
     */
    public function disable(): void
    {
        Menu::disable('examples/vueRouter');
    }

}