<?php

namespace modules\vuerouter;

use app\common\library\Menu;
use app\admin\model\MenuRule;

class Vuerouter
{
    public function install()
    {
        $examplesMenu = MenuRule::where('name', 'examples')->value('id');
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
            $examplesMenu = MenuRule::where('name', 'examples')->value('id');
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

    public function uninstall()
    {
        Menu::delete('examples/vueRouter', true);
    }

    public function enable()
    {
        Menu::enable('examples/vueRouter');
    }

    public function disable()
    {
        Menu::disable('examples/vueRouter');
    }

}