<?php

namespace aws;

use ba\cms\utils\AwsHelper;

class AwsHelperTest extends \PHPUnit\Framework\TestCase
{
    // 测试连接是否成功
    public function testBucketExist() {
        $this->assertTrue((new AwsHelper())->bucketExists("cms-oss"));
    }
}
