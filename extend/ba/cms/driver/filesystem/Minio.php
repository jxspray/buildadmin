<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2021 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: yunwuxin <448901948@qq.com>
// +----------------------------------------------------------------------
declare (strict_types = 1);

namespace ba\cms\driver\filesystem;

use Aws\Handler\GuzzleV6\GuzzleHandler;
use Aws\S3\S3Client;
use ba\cms\utils\AwsHelper;
use League\Flysystem\FilesystemAdapter;
use League\Flysystem\PathPrefixer;
use League\Flysystem\WhitespacePathNormalizer;
use think\filesystem\Driver;

class Minio extends Driver
{
    protected function createAdapter(): FilesystemAdapter
    {
        $handler = new GuzzleHandler();
        $options = array_merge($this->config, ['http_handler' => $handler]);
        $client  = new S3Client($options);
//        return new AwsS3Adapter($client, $options['bucket_name'], '');
        return new AwsHelper($client, $options['bucket'], "");
    }

    protected function prefixer()
    {
        if (!$this->prefixer) {
            $this->prefixer = new PathPrefixer($this->config['root'], DIRECTORY_SEPARATOR);
        }
        return $this->prefixer;
    }

    protected function normalizer()
    {
        if (!$this->normalizer) {
            $this->normalizer = new WhitespacePathNormalizer();
        }
        return $this->normalizer;
    }

    /**
     * 获取文件访问地址
     * @param string $path 文件路径
     * @return string
     */
    public function url(string $path): string
    {
        $path = $this->normalizer()->normalizePath($path);

        if (isset($this->config['url'])) {
            return $this->concatPathToUrl($this->config['url'], $path);
        }
        return parent::url($path);
    }

    public function path(string $path): string
    {
        return $this->prefixer()->prefixPath($path);
    }
}
