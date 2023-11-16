<?php

namespace modules\cms;

use app\common\model\Attachment;
use ba\Filesystem;
use think\App;
use app\common\library\Menu;
use app\admin\model\MenuRule;
use think\facade\Event;

class Cms
{

    private string $uid = 'alioss';

    /**
     * @throws \Throwable
     */
    public function AppInit(): void
    {
        // 上传配置初始化
        Event::listen('uploadConfigInit', function (App $app) {
            $uploadConfig = get_sys_config('', 'upload');
            if ($uploadConfig['upload_mode'] == 'serveoss' && empty($app->request->upload)) {
                $bucketUrl    = 'https://api.oss.jxspray.top';
                $upload       = \think\facade\Config::get('upload');
                $maxSize      = Filesystem::fileUnitToByte($upload['maxsize']);
                $conditions[] = ['content-length-range', 0, $maxSize];
                $expire       = time() + 3600;
                $policy       = base64_encode(json_encode([
                    'expiration' => date('Y-m-d\TH:i:s.Z\Z', $expire),
                    'conditions' => $conditions,
                ]));
                $signature    = base64_encode(hash_hmac('sha1', $policy, $uploadConfig['upload_secret_key'], true));

                $app->request->upload = [
                    'cdn'    => $uploadConfig['upload_cdn_url'] ?: $bucketUrl,
                    'mode'   => $uploadConfig['upload_mode'],
                    'url'    => $bucketUrl,
                    'accessKey' => '5GX4DZWmnObk0OLCQW8m',
                    'secretKey' => 'qi9uyC4kvQT9DEsQR1YDVpbvXDxVekdDR9ZLLaQW',
                    'bucket' => "cms-oss",
                    'params' => [
                        'OSSAccessKeyId' => $uploadConfig['upload_access_id'],
                        'policy'         => $policy,
                        'Signature'      => $signature,
                        'Expires'        => $expire,
                    ]
                ];
            }
        });

        // 附件管理中删除了文件
        Event::listen('AttachmentDel', function (Attachment $attachment) {
            if ($attachment->storage != 'serveoss') {
                return true;
            }
            $uploadConfig = get_sys_config('', 'upload');
            if (!$uploadConfig['upload_access_id'] || !$uploadConfig['upload_secret_key'] || !$uploadConfig['upload_bucket']) {
                return true;
            }
            $OssClient = new OssClient($uploadConfig['upload_access_id'], $uploadConfig['upload_secret_key'], 'http://' . $uploadConfig['upload_url'] . '.aliyuncs.com');
            $url       = str_replace(full_url(), '', ltrim($attachment->url, '/'));
            $OssClient->deleteObject($uploadConfig['upload_bucket'], $url);
            return true;
        });
    }

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
