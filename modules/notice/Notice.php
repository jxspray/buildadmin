<?php

namespace modules\notice;

use app\common\library\Menu;
use app\admin\model\MenuRule;

class Notice
{
    public function install()
    {
        $pMenu = MenuRule::where('name', 'routine')->value('id');
        $menu  = [
            [
                'type'      => 'menu',
                'title'     => '通知公告管理',
                'name'      => 'routine/notice',
                'path'      => 'routine/notice',
                'icon'      => 'el-icon-ChatLineRound',
                'menu_type' => 'tab',
                'component' => '/src/views/backend/routine/notice/index.vue',
                'keepalive' => '1',
                'pid'       => $pMenu ? $pMenu : 0,
                'children'  => [
                    ['type' => 'button', 'title' => '查看', 'name' => 'routine/notice/index'],
                    ['type' => 'button', 'title' => '添加', 'name' => 'routine/notice/add'],
                    ['type' => 'button', 'title' => '编辑', 'name' => 'routine/notice/edit'],
                    ['type' => 'button', 'title' => '删除', 'name' => 'routine/notice/del'],
                    ['type' => 'button', 'title' => '快速排序', 'name' => 'routine/notice/sortable'],
                ],
            ]
        ];
        Menu::create($menu);
    }

    public function uninstall()
    {
        Menu::delete('routine/notice', true);
    }

    public function enable()
    {
        Menu::enable('routine/notice');
    }

    public function disable()
    {
        Menu::disable('routine/notice');
    }

}