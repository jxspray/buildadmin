<?php

namespace modules\cms;

use think\facade\Db;
use app\common\library\Menu;
use app\admin\model\MenuRule;

class Cms
{
    /**
     * 安装模块时执行的方法
     */
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
                        'title'     => 'CMS配置',
                        'name'      => 'cms/config',
                        'path'      => 'cms/config',
                        'icon'      => 'el-icon-ChatLineRound',
                        'menu_type' => 'tab',
                        'component' => '/src/views/backend/cms/config/index.vue',
                        'keepalive' => '1',
                        'children'  => [
                            ['type' => 'button', 'title' => '查看', 'name' => 'cms/config/index'],
                            ['type' => 'button', 'title' => '添加', 'name' => 'cms/config/add'],
                            ['type' => 'button', 'title' => '编辑', 'name' => 'cms/config/edit'],
                            ['type' => 'button', 'title' => '删除', 'name' => 'cms/config/del'],
                            ['type' => 'button', 'title' => '快速排序', 'name' => 'cms/config/sortable'],
                        ]
                    ],
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
                    ],
                    [
                        'type'      => 'menu',
                        'title'     => '字段管理',
                        'name'      => 'cms/fields',
                        'path'      => 'cms/fields',
                        'icon'      => 'el-icon-ChatLineRound',
                        'menu_type' => 'tab',
                        'component' => '/src/views/backend/cms/fields/index.vue',
                        'keepalive' => '1',
                        'children'  => [
                            ['type' => 'button', 'title' => '查看', 'name' => 'cms/fields/index'],
                            ['type' => 'button', 'title' => '添加', 'name' => 'cms/fields/add'],
                            ['type' => 'button', 'title' => '编辑', 'name' => 'cms/fields/edit'],
                            ['type' => 'button', 'title' => '删除', 'name' => 'cms/fields/del'],
                            ['type' => 'button', 'title' => '快速排序', 'name' => 'cms/fields/sortable'],
                        ]
                    ],
                    [
                        'type'      => 'menu',
                        'title'     => '幻灯片管理',
                        'name'      => 'cms/slide',
                        'path'      => 'cms/slide',
                        'icon'      => 'el-icon-ChatLineRound',
                        'menu_type' => 'tab',
                        'component' => '/src/views/backend/cms/slide/index.vue',
                        'keepalive' => '1',
                        'children'  => [
                            ['type' => 'button', 'title' => '查看', 'name' => 'cms/slide/index'],
                            ['type' => 'button', 'title' => '添加', 'name' => 'cms/slide/add'],
                            ['type' => 'button', 'title' => '编辑', 'name' => 'cms/slide/edit'],
                            ['type' => 'button', 'title' => '删除', 'name' => 'cms/slide/del'],
                            ['type' => 'button', 'title' => '快速排序', 'name' => 'cms/slide/sortable'],
                        ]
                    ],
                    [
                        'type'      => 'menu',
                        'title'     => '幻灯片图册管理',
                        'name'      => 'cms/slide/data',
                        'path'      => 'cms/slide/data',
                        'icon'      => 'el-icon-ChatLineRound',
                        'menu_type' => 'tab',
                        'component' => '/src/views/backend/cms/slide/data/index.vue',
                        'keepalive' => '1',
                        'children'  => [
                            ['type' => 'button', 'title' => '查看', 'name' => 'cms/slide/data/index'],
                            ['type' => 'button', 'title' => '添加', 'name' => 'cms/slide/data/add'],
                            ['type' => 'button', 'title' => '编辑', 'name' => 'cms/slide/data/edit'],
                            ['type' => 'button', 'title' => '删除', 'name' => 'cms/slide/data/del'],
                            ['type' => 'button', 'title' => '快速排序', 'name' => 'cms/slide/data/sortable'],
                        ]
                    ],
                    [
                        'type'      => 'menu',
                        'title'     => '友情链接',
                        'name'      => 'cms/link',
                        'path'      => 'cms/link',
                        'icon'      => 'el-icon-ChatLineRound',
                        'menu_type' => 'tab',
                        'component' => '/src/views/backend/cms/link/index.vue',
                        'keepalive' => '1',
                        'children'  => [
                            ['type' => 'button', 'title' => '查看', 'name' => 'cms/link/index'],
                            ['type' => 'button', 'title' => '添加', 'name' => 'cms/link/add'],
                            ['type' => 'button', 'title' => '编辑', 'name' => 'cms/link/edit'],
                            ['type' => 'button', 'title' => '删除', 'name' => 'cms/link/del'],
                            ['type' => 'button', 'title' => '快速排序', 'name' => 'cms/link/sortable'],
                        ]
                    ]
                ],
            ]
        ];
        Menu::create($menu);

    }

    /**
     * 卸载模块时执行的方法
     */
    public function uninstall()
    {
        // 删除添加的菜单
        Menu::delete('cms', true);
    }

    /**
     * 启用模块时执行的方法
     */
    public function enable()
    {
        // 启用模块添加的菜单
        Menu::enable('cms');
    }

    /**
     * 禁用模块时执行的方法
     */
    public function disable()
    {
        // 禁用模块添加的菜单
        Menu::disable('cms');
    }

    /**
     * 升级模块时执行的方法
     */
    public function update()
    {
    }
}
