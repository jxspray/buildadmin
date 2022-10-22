<?php

namespace modules\cms;

use app\common\library\Menu;
use app\admin\model\MenuRule;

class Cms
{
    public function install()
    {
        $menu  = [
            [
                'type'      => 'menu_dir',
                'title'     => '内容管理',
                'name'      => 'cms',
                'path'      => 'cms',
                'icon'      => 'el-icon-ChatLineRound',
                'menu_type' => 'tab',
                'keepalive' => '1',
                'pid'       => 0,
                'children'  => [
                    [
                        'type'      => 'menu',
                        'title'     => '栏目管理',
                        'name'      => 'cms/catalog',
                        'path'      => 'cms/catalog',
                        'icon'      => 'el-icon-ChatLineRound',
                        'menu_type' => 'tab',
                        'component' => '/src/views/backend/cms/catalog/index.vue',
                        'keepalive' => '1',
                        'children'  => [
                            ['type' => 'button', 'title' => '查看', 'name' => 'cms/catalog/index'],
                            ['type' => 'button', 'title' => '添加', 'name' => 'cms/catalog/add'],
                            ['type' => 'button', 'title' => '编辑', 'name' => 'cms/catalog/edit'],
                            ['type' => 'button', 'title' => '删除', 'name' => 'cms/catalog/del'],
                            ['type' => 'button', 'title' => '快速排序', 'name' => 'cms/catalog/sortable'],
                        ]
                    ],
                    [
                        'type'      => 'menu',
                        'title'     => '模型管理',
                        'name'      => 'cms/module',
                        'path'      => 'cms/module',
                        'icon'      => 'el-icon-ChatLineRound',
                        'menu_type' => 'tab',
                        'component' => '/src/views/backend/cms/module/index.vue',
                        'keepalive' => '1',
                        'children'  => [
                            ['type' => 'button', 'title' => '查看', 'name' => 'cms/module/index'],
                            ['type' => 'button', 'title' => '添加', 'name' => 'cms/module/add'],
                            ['type' => 'button', 'title' => '编辑', 'name' => 'cms/module/edit'],
                            ['type' => 'button', 'title' => '删除', 'name' => 'cms/module/del'],
                            ['type' => 'button', 'title' => '快速排序', 'name' => 'cms/module/sortable'],
                        ]
                    ]
                ],
            ]
        ];
        Menu::create($menu);
    }

    public function uninstall()
    {
        Menu::delete('cms', true);
    }

    public function enable()
    {
        Menu::enable('cms');
    }

    public function disable()
    {
        Menu::disable('cms');
    }

}
