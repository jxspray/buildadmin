<?php

namespace feature;

use app\admin\facade\Filesystem;
require __DIR__ . '/../../vendor/topthink/framework/src/helper.php';

class AwsTest extends \PHPUnit\Framework\TestCase
{

    // 测试连接是否成功
    public function testBucketExist() {
        // 设置config

        \think\facade\Config::__make(app())->load("filesystem");
        $result = Filesystem::disk("s3")->listBuckets();
        $names = $result->search('Buckets[].Name');

        $this->assertTrue(in_array("cms-oss", $names));
    }
}
