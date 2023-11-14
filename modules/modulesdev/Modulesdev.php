<?php

namespace modules\modulesdev;

use Throwable;
use think\facade\Console;
use app\common\library\Menu;

class Modulesdev
{
    public function AppInit(): void
    {
        if (request()->isCli()) {
            Console::starting(function (\think\Console $console) {
                $console->addCommand('app\admin\command\FilesWatch');
            });
        }
    }

    /**
     * 安装
     * @throws Throwable
     */
    public function install(): void
    {
        $menu = [
            [
                'type'      => 'menu',
                'title'     => '模块开发辅助',
                'name'      => 'modulesdev',
                'path'      => 'modulesdev',
                'icon'      => 'fa fa-flask',
                'menu_type' => 'tab',
                'component' => '/src/views/backend/modulesdev/index.vue',
                'keepalive' => '1',
                'children'  => [
                    ['type' => 'button', 'title' => '查看', 'name' => 'modulesdev/index'],
                    ['type' => 'button', 'title' => '文件', 'name' => 'modulesdev/dir'],
                    ['type' => 'button', 'title' => '管理', 'name' => 'modulesdev/manage'],
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
        // 删除添加的菜单
        Menu::delete('modulesdev', true);
    }

    /**
     * 启用
     * @throws Throwable
     */
    public function enable(): void
    {
        Menu::enable('modulesdev');
    }

    /**
     * 启用
     * @throws Throwable
     */
    public function disable(): void
    {
        Menu::disable('modulesdev');
    }
}