<?php

namespace ba\cms\utils;

use Aws\S3\Exception\S3MultipartUploadException;
use Aws\S3\MultipartUploader;
use Aws\s3\S3Client;
use Aws\S3\S3ClientInterface;
use League\Flysystem\Config;
use League\Flysystem\FileAttributes;
use League\Flysystem\FilesystemAdapter;
use League\Flysystem\Util;

class AwsHelper implements FilesystemAdapter
{
    private S3ClientInterface $s3Client;
    private string $bucket; //桶名称
    protected array $options = [];
    protected bool $streamReads = false;

    public function __construct(S3ClientInterface $client, $bucket, $prefix = '', array $options = [], $streamReads = true)
    {
        $this->s3Client = $client;
        $this->bucket = $bucket;
        $this->setPathPrefix($prefix);
        $this->options = $options;
        $this->streamReads = $streamReads;
    }

    /**
     * {@inheritdoc}
     */
    public function setPathPrefix($prefix)
    {
        $prefix = ltrim((string) $prefix, '/');


        $prefix = (string) $prefix;

        if ($prefix === '') {
            $this->pathPrefix = null;

            return;
        }

        $this->pathPrefix = rtrim($prefix, '\\/') . $this->pathSeparator;

    }

    /**
     * 判断bucket是否存在的另一种写法
     * @param $bucket
     * @return bool
     */
    public function bucketExists($bucket = null): bool
    {
        $result = $this->s3Client->listBuckets();
        $names = $result->search('Buckets[].Name');

        if ($bucket) {
            if (!in_array($bucket, $names)) {
                return false;
            }
        } else {
            if (!in_array($this->bucket, $names)) {
                return false;
            }
        }

        return true;
    }

    /**
     * 判断 查询对象是否存在
     * @param $bucket
     * @return bool
     */
    public function objectExist($object): bool
    {
        return $this->s3Client->doesObjectExist($this->bucket, $object);

    }

    /**
     * 上传
     * @param $objectPath
     * @param $objectName
     * @return bool|array
     */
    public function upLoadObject($objectPath, $objectName = null): bool|array
    {
        if (!$objectName) {
            $objectName = basename($objectPath);
        }

        $uploader = new MultipartUploader($this->s3Client, $objectPath, [
            'bucket' => $this->bucket,
            'key' => $objectName,
        ]);

        $result = $uploader->upload();

        if (isset($result["@metadata"]["statusCode"]) && $result["@metadata"]["statusCode"] == 200) {
            return [
                'bucket' => $this->bucket,
                'name' => $objectName,
                'path' => $this->endpoint . "/" . $this->bucket . '/' . $objectName
            ];
        } else {
            return false;
        }
    }

    /**
     * 上传文件到某文件夹下（上传函数upLoadObject也能实现此功能，可自己研究下）
     * @param $objectPath : 本地文件路径 li:/tmp/test.txt
     * @param $folderPath : minio中桶下的文件夹路径 li:folder/test
     * @param $objectName : 对象名称（重命名用） li: abc.txt
     * @return bool|array
     */
    public function upLoadObjectToFolder($objectPath, $folderPath, $objectName = null): bool|array
    {
        if (!$objectName) {
            $objectName = basename($objectPath);
        }

        $key = $folderPath . '/' . $objectName;

        $result = $this->s3Client->putObject([
            'Bucket' => $this->bucket,
            'Key' => $key,
            'Body' => file_get_contents($objectPath) //要上传的文件
        ]);

        if (isset($result["@metadata"]["statusCode"]) && $result["@metadata"]["statusCode"] == 200) {
            return [
                'bucket' => $this->bucket,
                'name' => $objectName,
                'path' => $this->bucket . '/' . $key
            ];
        } else {
            return false;
        }
    }

    /**
     * 多文件上传
     * @param $objectPathArr
     * @return array
     */
    public function batchUpload($objectPathArr): array
    {
        //路径数组
        $pathArr = array();
        $s3 = $this->s3Client;

        foreach ($objectPathArr as $object) {

            if (file_exists($object)) {
                //文件扩展名
                $extend = substr(strrchr($object, '.'), 1);

                //文件名
                $fileName = date('Ymd') . '-' . uniqid() . '.' . $extend;

                $return = $s3->putObject([
                    'Bucket' => $this->bucket, //存储桶名称
                    'Key' => $fileName, //文件名（包括后缀名）
                    'Body' => file_get_contents($object) //要上传的文件
                ]);

                if (isset($return['@metadata']['statusCode']) && $return['@metadata']['statusCode'] == 200) {

                    $pathArr[] = [
                        'bucket' => $this->bucket,
                        'name' => $fileName,
                        'path' => $this->bucket . '/' . $fileName
                    ];

                } else {
                    //此处可增加日志记录
                    continue;
                }
            }
        }

        return $pathArr;
    }

    /**
     * 复制（重命名文件）
     * @param $sourceObject
     * @param $objectName
     * @return bool|array
     */
    public function copyObject($sourceObject, $objectName = null): bool|array
    {
        if (!$objectName) {
            $extend = substr(strrchr($sourceObject, '.'), 1);
            $objectName = date('Ymd') . '-' . uniqid() . '.' . $extend;
        }

        //源对象需包含桶+key
        $source = '/' . $this->bucket . '/' . $sourceObject;

        $result = $this->s3Client->copyObject([
            'Bucket' => $this->bucket, //存储桶名称
            'CopySource' => $source,
            'Key' => $objectName,
        ]);

        if (isset($result["@metadata"]["statusCode"]) && $result["@metadata"]["statusCode"] == 200) {
            return [
                'bucket' => $this->bucket,
                'name' => $objectName,
                'path' => $this->bucket . '/' . $objectName
            ];
        } else {
            return false;
        }
    }

    /**
     * 获取单个对象信息
     * @param $object
     * @return array|mixed|null
     */
    public function getMetaData($object): mixed
    {
        $retrive = $this->s3Client->getObject([
            'Bucket' => $this->bucket,
            'Key' => $object,
        ]);

        if (!isset($retrive['@metadata'])) {
            return [];
        }

        return $retrive['@metadata'];
    }

    /**
     * 获取对象连接
     * @param $object : 对象路径 例：若在文件夹内 aaa/bbb/ccc.png 桶根目录下 ddd.png
     * @param $expires : 有效期
     * @return string
     */
    public function getUrl($object, $expires = null): string
    {
        $cmd = $this->s3Client->getCommand('GetObject', [
            'Bucket' => $this->bucket,
            'Key' => $object
        ]);

        if (!$expires) {
            $expires = '+1 days';
        }

        $request = $this->s3Client->createPresignedRequest($cmd, $expires);
        $presignedUrl = (string)$request->getUri();

        return $presignedUrl;

        //测试-图片
        //return "<img src='{$presignedUrl}'/>";
    }

    /**
     * 获取多个对象信息
     * @param $data
     * @return array|mixed
     */
    public function getAll($data): mixed
    {
        $param = [
            'Bucket' => $this->bucket
        ];

        if (isset($data['num'])) {
            $param['MaxKeys'] = $data['num'];
        }

        if (isset($data['prefix'])) {
            $param['Prefix'] = $data['prefix'];
        }

        $retrive = $this->s3Client->listObjects($param);

        if (isset($retrive['Contents'])) {
            return $retrive['Contents'];
        } else {
            return [];
        }
    }

    /**
     * 删除单个文件
     * @param $object
     * @return bool
     */
    public function deleteObject($object): bool
    {

        $result = $this->s3Client->deleteObject([
            'Bucket' => $this->bucket,
            'Key' => $object,
        ]);

        if (isset($result['@metadata']['statusCode']) && $result['@metadata']['statusCode'] == 204) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 删除多个文件
     * @param $objectArr
     * @return bool
     */
    public function batchDeleteObject($objectArr): bool
    {
        $keys = array();

        foreach ($objectArr as $item) {
            $keys[] = array('Key' => $item);
        }

        $s3 = $this->s3Client;

        $result = $s3->deleteObjects([
            'Bucket' => $this->bucket,
            'Delete' => ['Objects' => $keys]
        ]);

        if (isset($result["@metadata"]["statusCode"]) && $result["@metadata"]["statusCode"] == 200) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 上传文件夹
     * @param $folderPath : 文件夹路径
     * @param $folderName : 指定文件夹名称
     * @return bool
     */
    public function uploadFolder($folderPath, $folderName = null): bool
    {
        if (!$folderName) {
            $folderName = basename($folderPath);
        }

        $keyPrefix = $folderName . '/';

        $options['params']['ACL'] = 'public-read';

        $this->s3Client->uploadDirectory($folderPath, $this->bucket, $keyPrefix, $options);

        return true;
    }

    /**
     * 删除文件夹
     * @param $folderPath
     * @return bool
     */
    public function deleteFolder($folderPath): bool
    {
        $folderName = basename($folderPath);

        $keyPrefix = $folderName . '/';

        $this->s3Client->deleteMatchingObjects($this->bucket, $keyPrefix);

        return true;
    }

    public function fileExists(string $path): bool
    {
        return false;
        // TODO: Implement fileExists() method.
    }


    /**
     * Upload an object.
     *
     * @param string          $path
     * @param string|resource $body
     * @param Config          $config
     *
     * @return array|bool
     */
    protected function upload($path, $body, Config $config)
    {
        $key = $this->applyPathPrefix($path);
        $options = $this->getOptionsFromConfig($config);
        $acl = array_key_exists('ACL', $options) ? $options['ACL'] : 'private';

        if (!$this->isOnlyDir($path)) {
            if ( ! isset($options['ContentType'])) {
                $options['ContentType'] = \League\Flysystem\Util::guessMimeType($path, $body);
            }

            if ( ! isset($options['ContentLength'])) {
                $options['ContentLength'] = is_resource($body) ? Util::getStreamSize($body) : Util::contentSize($body);
            }

            if ($options['ContentLength'] === null) {
                unset($options['ContentLength']);
            }
        }

        try {
            $this->s3Client->upload($this->bucket, $key, $body, $acl, ['params' => $options]);
        } catch (S3MultipartUploadException $multipartUploadException) {
            return false;
        }

        return $this->normalizeResponse($options, $path);
    }
    public function write(string $path, string $contents, Config $config): void
    {
        $this->upload($path, $contents, $config);
    }

    public function writeStream(string $path, $contents, Config $config): void
    {
        // TODO: Implement writeStream() method.
    }

    public function read(string $path): string
    {
        // TODO: Implement read() method.
    }

    public function readStream(string $path)
    {
        // TODO: Implement readStream() method.
    }

    public function delete(string $path): void
    {
        // TODO: Implement delete() method.
    }

    public function deleteDirectory(string $path): void
    {
        // TODO: Implement deleteDirectory() method.
    }

    public function createDirectory(string $path, Config $config): void
    {
        // TODO: Implement createDirectory() method.
    }

    public function setVisibility(string $path, string $visibility): void
    {
        // TODO: Implement setVisibility() method.
    }

    public function visibility(string $path): FileAttributes
    {
        // TODO: Implement visibility() method.
    }

    public function mimeType(string $path): FileAttributes
    {
        // TODO: Implement mimeType() method.
    }

    public function lastModified(string $path): FileAttributes
    {
        // TODO: Implement lastModified() method.
    }

    public function fileSize(string $path): FileAttributes
    {
        // TODO: Implement fileSize() method.
    }

    public function listContents(string $path, bool $deep): iterable
    {
        // TODO: Implement listContents() method.
    }

    public function move(string $source, string $destination, Config $config): void
    {
        // TODO: Implement move() method.
    }

    public function copy(string $source, string $destination, Config $config): void
    {
        // TODO: Implement copy() method.
    }




    /**
     * {@inheritdoc}
     */
    public function applyPathPrefix($path)
    {
        return ltrim($this->getPathPrefix() . ltrim($path, '\\/'), '/');
    }

    /**
     * Get the path prefix.
     *
     * @return string|null path prefix or null if pathPrefix is empty
     */
    public function getPathPrefix()
    {
        return $this->pathPrefix;
    }

    /**
     * @var string|null path prefix
     */
    protected $pathPrefix;

    /**
     * @var string
     */
    protected $pathSeparator = '/';
}
