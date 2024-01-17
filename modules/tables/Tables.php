<?php

namespace modules\tables;

use Throwable;
use app\admin\model\AdminRule;
use app\common\library\Menu;

class Tables
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
                'type'     => 'menu_dir',
                'title'    => '表格开发示例',
                'name'     => 'examples/table',
                'path'     => 'examples/table',
                'icon'     => 'fa fa-table',
                'pid'      => $examplesMenu,
                'children' => [
                    [
                        'type'      => 'menu',
                        'title'     => '操作表格的方法',
                        'name'      => 'examples/table/method',
                        'path'      => 'examples/table/method',
                        'menu_type' => 'tab',
                        'component' => '/src/views/backend/examples/table/method/index.vue',
                        'keepalive' => '1',
                        'weigh'     => '99',
                        'children'  => [
                            ['type' => 'button', 'title' => '查看', 'name' => 'examples/table/method/index'],
                            ['type' => 'button', 'title' => '添加', 'name' => 'examples/table/method/add'],
                            ['type' => 'button', 'title' => '编辑', 'name' => 'examples/table/method/edit'],
                            ['type' => 'button', 'title' => '删除', 'name' => 'examples/table/method/del'],
                        ],
                    ],
                    [
                        'type'      => 'menu',
                        'title'     => '编程式刷新表格',
                        'name'      => 'examples/table/refresh',
                        'path'      => 'examples/table/refresh',
                        'menu_type' => 'tab',
                        'component' => '/src/views/backend/examples/table/refresh/index.vue',
                        'keepalive' => '1',
                        'weigh'     => '98',
                        'children'  => [
                            ['type' => 'button', 'title' => '查看', 'name' => 'examples/table/refresh/index'],
                            ['type' => 'button', 'title' => '添加', 'name' => 'examples/table/refresh/add'],
                            ['type' => 'button', 'title' => '编辑', 'name' => 'examples/table/refresh/edit'],
                            ['type' => 'button', 'title' => '删除', 'name' => 'examples/table/refresh/del'],
                        ],
                    ],
                    [
                        'type'      => 'menu',
                        'title'     => '详情按钮和弹窗',
                        'name'      => 'examples/table/dialog',
                        'path'      => 'examples/table/dialog',
                        'menu_type' => 'tab',
                        'component' => '/src/views/backend/examples/table/dialog/index.vue',
                        'keepalive' => '1',
                        'weigh'     => '97',
                        'children'  => [
                            ['type' => 'button', 'title' => '查看', 'name' => 'examples/table/dialog/index'],
                            ['type' => 'button', 'title' => '添加', 'name' => 'examples/table/dialog/add'],
                            ['type' => 'button', 'title' => '编辑', 'name' => 'examples/table/dialog/edit'],
                            ['type' => 'button', 'title' => '删除', 'name' => 'examples/table/dialog/del'],
                        ],
                    ],
                    [
                        'type'      => 'menu',
                        'title'     => '详情按钮和弹窗2',
                        'name'      => 'examples/table/dialog2',
                        'path'      => 'examples/table/dialog2',
                        'menu_type' => 'tab',
                        'component' => '/src/views/backend/examples/table/dialog2/index.vue',
                        'keepalive' => '1',
                        'weigh'     => '96',
                        'children'  => [
                            ['type' => 'button', 'title' => '查看', 'name' => 'examples/table/dialog2/index'],
                            ['type' => 'button', 'title' => '添加', 'name' => 'examples/table/dialog2/add'],
                            ['type' => 'button', 'title' => '编辑', 'name' => 'examples/table/dialog2/edit'],
                            ['type' => 'button', 'title' => '删除', 'name' => 'examples/table/dialog2/del'],
                        ],
                    ],
                    [
                        'type'      => 'menu',
                        'title'     => '表格事件监听',
                        'name'      => 'examples/table/event',
                        'path'      => 'examples/table/event',
                        'menu_type' => 'tab',
                        'component' => '/src/views/backend/examples/table/event/index.vue',
                        'keepalive' => '1',
                        'weigh'     => '95',
                        'children'  => [
                            ['type' => 'button', 'title' => '查看', 'name' => 'examples/table/event/index'],
                            ['type' => 'button', 'title' => '添加', 'name' => 'examples/table/event/add'],
                            ['type' => 'button', 'title' => '编辑', 'name' => 'examples/table/event/edit'],
                            ['type' => 'button', 'title' => '删除', 'name' => 'examples/table/event/del'],
                        ],
                    ],
                    [
                        'type'      => 'menu',
                        'title'     => '表格事件监听2',
                        'name'      => 'examples/table/event2',
                        'path'      => 'examples/table/event2',
                        'menu_type' => 'tab',
                        'component' => '/src/views/backend/examples/table/event2/index.vue',
                        'keepalive' => '1',
                        'weigh'     => '94',
                        'children'  => [
                            ['type' => 'button', 'title' => '查看', 'name' => 'examples/table/event2/index'],
                            ['type' => 'button', 'title' => '添加', 'name' => 'examples/table/event2/add'],
                            ['type' => 'button', 'title' => '编辑', 'name' => 'examples/table/event2/edit'],
                            ['type' => 'button', 'title' => '删除', 'name' => 'examples/table/event2/del'],
                        ],
                    ],
                    [
                        'type'      => 'menu',
                        'title'     => '自定义表头按钮',
                        'name'      => 'examples/table/headerBtn',
                        'path'      => 'examples/table/headerBtn',
                        'menu_type' => 'tab',
                        'component' => '/src/views/backend/examples/table/headerBtn/index.vue',
                        'keepalive' => '1',
                        'weigh'     => '93',
                        'children'  => [
                            ['type' => 'button', 'title' => '查看', 'name' => 'examples/table/headerBtn/index'],
                            ['type' => 'button', 'title' => '添加', 'name' => 'examples/table/headerBtn/add'],
                            ['type' => 'button', 'title' => '编辑', 'name' => 'examples/table/headerBtn/edit'],
                            ['type' => 'button', 'title' => '删除', 'name' => 'examples/table/headerBtn/del'],
                        ],
                    ],
                    [
                        'type'      => 'menu',
                        'title'     => '固定列固定表头',
                        'name'      => 'examples/table/fixed',
                        'path'      => 'examples/table/fixed',
                        'menu_type' => 'tab',
                        'component' => '/src/views/backend/examples/table/fixed/index.vue',
                        'keepalive' => '1',
                        'weigh'     => '92',
                        'children'  => [
                            ['type' => 'button', 'title' => '查看', 'name' => 'examples/table/fixed/index'],
                            ['type' => 'button', 'title' => '添加', 'name' => 'examples/table/fixed/add'],
                            ['type' => 'button', 'title' => '编辑', 'name' => 'examples/table/fixed/edit'],
                            ['type' => 'button', 'title' => '删除', 'name' => 'examples/table/fixed/del'],
                        ],
                    ],
                    [
                        'type'      => 'menu',
                        'title'     => '表尾合计行',
                        'name'      => 'examples/table/summary',
                        'path'      => 'examples/table/summary',
                        'menu_type' => 'tab',
                        'component' => '/src/views/backend/examples/table/summary/index.vue',
                        'keepalive' => '1',
                        'weigh'     => '91',
                        'children'  => [
                            ['type' => 'button', 'title' => '查看', 'name' => 'examples/table/summary/index'],
                            ['type' => 'button', 'title' => '添加', 'name' => 'examples/table/summary/add'],
                            ['type' => 'button', 'title' => '编辑', 'name' => 'examples/table/summary/edit'],
                            ['type' => 'button', 'title' => '删除', 'name' => 'examples/table/summary/del'],
                        ],
                    ],
                    [
                        'type'      => 'menu',
                        'title'     => '带状态表格',
                        'name'      => 'examples/table/status',
                        'path'      => 'examples/table/status',
                        'menu_type' => 'tab',
                        'component' => '/src/views/backend/examples/table/status/index.vue',
                        'keepalive' => '1',
                        'weigh'     => '90',
                        'children'  => [
                            ['type' => 'button', 'title' => '查看', 'name' => 'examples/table/status/index'],
                            ['type' => 'button', 'title' => '添加', 'name' => 'examples/table/status/add'],
                            ['type' => 'button', 'title' => '编辑', 'name' => 'examples/table/status/edit'],
                            ['type' => 'button', 'title' => '删除', 'name' => 'examples/table/status/del'],
                        ],
                    ],
                    [
                        'type'      => 'menu',
                        'title'     => '多级表头',
                        'name'      => 'examples/table/mheader',
                        'path'      => 'examples/table/mheader',
                        'menu_type' => 'tab',
                        'component' => '/src/views/backend/examples/table/mheader/index.vue',
                        'keepalive' => '1',
                        'weigh'     => '89',
                        'children'  => [
                            ['type' => 'button', 'title' => '查看', 'name' => 'examples/table/mheader/index'],
                            ['type' => 'button', 'title' => '添加', 'name' => 'examples/table/mheader/add'],
                            ['type' => 'button', 'title' => '编辑', 'name' => 'examples/table/mheader/edit'],
                            ['type' => 'button', 'title' => '删除', 'name' => 'examples/table/mheader/del'],
                        ],
                    ],
                    [
                        'type'      => 'menu',
                        'title'     => '合并行或列',
                        'name'      => 'examples/table/span',
                        'path'      => 'examples/table/span',
                        'menu_type' => 'tab',
                        'component' => '/src/views/backend/examples/table/span/index.vue',
                        'keepalive' => '1',
                        'weigh'     => '88',
                        'children'  => [
                            ['type' => 'button', 'title' => '查看', 'name' => 'examples/table/span/index'],
                            ['type' => 'button', 'title' => '添加', 'name' => 'examples/table/span/add'],
                            ['type' => 'button', 'title' => '编辑', 'name' => 'examples/table/span/edit'],
                            ['type' => 'button', 'title' => '删除', 'name' => 'examples/table/span/del'],
                        ],
                    ],
                    [
                        'type'      => 'menu',
                        'title'     => '展开行',
                        'name'      => 'examples/table/expand',
                        'path'      => 'examples/table/expand',
                        'menu_type' => 'tab',
                        'component' => '/src/views/backend/examples/table/expand/index.vue',
                        'keepalive' => '1',
                        'weigh'     => '87',
                        'children'  => [
                            ['type' => 'button', 'title' => '查看', 'name' => 'examples/table/expand/index'],
                            ['type' => 'button', 'title' => '添加', 'name' => 'examples/table/expand/add'],
                            ['type' => 'button', 'title' => '编辑', 'name' => 'examples/table/expand/edit'],
                            ['type' => 'button', 'title' => '删除', 'name' => 'examples/table/expand/del'],
                        ],
                    ],
                    [
                        'type'      => 'menu',
                        'title'     => '树形数据',
                        'name'      => 'examples/table/tree',
                        'path'      => 'examples/table/tree',
                        'menu_type' => 'tab',
                        'component' => '/src/views/backend/examples/table/tree/index.vue',
                        'keepalive' => '1',
                        'weigh'     => '86',
                        'children'  => [
                            ['type' => 'button', 'title' => '查看', 'name' => 'examples/table/tree/index'],
                            ['type' => 'button', 'title' => '添加', 'name' => 'examples/table/tree/add'],
                            ['type' => 'button', 'title' => '编辑', 'name' => 'examples/table/tree/edit'],
                            ['type' => 'button', 'title' => '删除', 'name' => 'examples/table/tree/del'],
                        ],
                    ],
                    [
                        'type'      => 'menu_dir',
                        'title'     => '表格的表单',
                        'name'      => 'examples/table/form',
                        'path'      => 'examples/table/form',
                        'keepalive' => '1',
                        'weigh'     => '85',
                        'children'  => [
                            [
                                'type'      => 'menu',
                                'title'     => '数据编辑之前预处理',
                                'name'      => 'examples/table/form/edit',
                                'path'      => 'examples/table/form/edit',
                                'menu_type' => 'tab',
                                'component' => '/src/views/backend/examples/table/form/edit/index.vue',
                                'keepalive' => '1',
                                'weigh'     => '9',
                                'children'  => [
                                    ['type' => 'button', 'title' => '查看', 'name' => 'examples/table/form/edit/index'],
                                    ['type' => 'button', 'title' => '添加', 'name' => 'examples/table/form/edit/add'],
                                    ['type' => 'button', 'title' => '编辑', 'name' => 'examples/table/form/edit/edit'],
                                    ['type' => 'button', 'title' => '删除', 'name' => 'examples/table/form/edit/del'],
                                ],
                            ],
                            [
                                'type'      => 'menu',
                                'title'     => '表单提交之前预处理',
                                'name'      => 'examples/table/form/submit',
                                'path'      => 'examples/table/form/submit',
                                'menu_type' => 'tab',
                                'component' => '/src/views/backend/examples/table/form/submit/index.vue',
                                'keepalive' => '1',
                                'weigh'     => '8',
                                'children'  => [
                                    ['type' => 'button', 'title' => '查看', 'name' => 'examples/table/form/submit/index'],
                                    ['type' => 'button', 'title' => '添加', 'name' => 'examples/table/form/submit/add'],
                                    ['type' => 'button', 'title' => '编辑', 'name' => 'examples/table/form/submit/edit'],
                                    ['type' => 'button', 'title' => '删除', 'name' => 'examples/table/form/submit/del'],
                                ],
                            ],
                            [
                                'type'      => 'menu',
                                'title'     => '表单其他示例',
                                'name'      => 'examples/table/form/other',
                                'path'      => 'examples/table/form/other',
                                'menu_type' => 'tab',
                                'component' => '/src/views/backend/examples/table/form/other/index.vue',
                                'keepalive' => '1',
                                'weigh'     => '7',
                                'children'  => [
                                    ['type' => 'button', 'title' => '查看', 'name' => 'examples/table/form/other/index'],
                                    ['type' => 'button', 'title' => '添加', 'name' => 'examples/table/form/other/add'],
                                    ['type' => 'button', 'title' => '编辑', 'name' => 'examples/table/form/other/edit'],
                                    ['type' => 'button', 'title' => '删除', 'name' => 'examples/table/form/other/del'],
                                ],
                            ],
                        ],
                    ],
                    [
                        'type'      => 'menu_dir',
                        'title'     => '单元格自定义渲染',
                        'name'      => 'examples/table/cell',
                        'path'      => 'examples/table/cell',
                        'keepalive' => '1',
                        'weigh'     => '84',
                        'children'  => [
                            [
                                'type'      => 'menu',
                                'title'     => 'slot渲染',
                                'name'      => 'examples/table/cell/slot',
                                'path'      => 'examples/table/cell/slot',
                                'menu_type' => 'tab',
                                'component' => '/src/views/backend/examples/table/cell/slot/index.vue',
                                'keepalive' => '1',
                                'weigh'     => '9',
                                'children'  => [
                                    ['type' => 'button', 'title' => '查看', 'name' => 'examples/table/cell/slot/index'],
                                    ['type' => 'button', 'title' => '添加', 'name' => 'examples/table/cell/slot/add'],
                                    ['type' => 'button', 'title' => '编辑', 'name' => 'examples/table/cell/slot/edit'],
                                    ['type' => 'button', 'title' => '删除', 'name' => 'examples/table/cell/slot/del'],
                                ],
                            ],
                            [
                                'type'      => 'menu',
                                'title'     => '预设渲染方案',
                                'name'      => 'examples/table/cell/pre',
                                'path'      => 'examples/table/cell/pre',
                                'menu_type' => 'tab',
                                'component' => '/src/views/backend/examples/table/cell/pre/index.vue',
                                'keepalive' => '1',
                                'weigh'     => '8',
                                'children'  => [
                                    ['type' => 'button', 'title' => '查看', 'name' => 'examples/table/cell/pre/index'],
                                    ['type' => 'button', 'title' => '添加', 'name' => 'examples/table/cell/pre/add'],
                                    ['type' => 'button', 'title' => '编辑', 'name' => 'examples/table/cell/pre/edit'],
                                    ['type' => 'button', 'title' => '删除', 'name' => 'examples/table/cell/pre/del'],
                                    ['type' => 'button', 'title' => '快速排序', 'name' => 'examples/table/cell/pre/sortable'],
                                ],
                            ],
                        ],
                    ],
                ],
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
        Menu::delete('examples/table', true);
    }

    /**
     * 启用
     * @throws Throwable
     */
    public function enable(): void
    {
        Menu::enable('examples/table');
    }

    /**
     * 禁用
     * @throws Throwable
     */
    public function disable(): void
    {
        Menu::disable('examples/table');
    }
}