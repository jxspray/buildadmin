<?php

return [
    // 默认磁盘
    'default' => env('filesystem.driver', 'local'),
    // 磁盘列表
    'disks'   => [
        'local'  => [
            'type' => 'local',
            'root' => app()->getRuntimePath() . 'storage',
        ],
        'public' => [
            // 磁盘类型
            'type'       => 'local',
            // 磁盘路径
            'root'       => app()->getRootPath() . 'public/storage',
            // 磁盘路径对应的外部URL路径
            'url'        => '/storage',
            // 可见性
            'visibility' => 'public',
        ],
        // 更多的磁盘配置信息
        'minio'  => [
            'type' => \ba\cms\driver\filesystem\Minio::class,
            'host' => 'https://api.oss.jxspray.top',
            'region' => 'cn-north-1',
            'version' => 'latest',
            'bucket' => 'cms-oss',
            'credentials' => [
                'key' => '5GX4DZWmnObk0OLCQW8m',
                'secret' => 'qi9uyC4kvQT9DEsQR1YDVpbvXDxVekdDR9ZLLaQW',
            ],
        ],
    ],
];
