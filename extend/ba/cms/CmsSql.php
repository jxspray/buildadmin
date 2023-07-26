<?php

namespace ba\cms;

use Exception;

class CmsSql
{
    private static self $instance;
    private string $pattern;
    private string $table;

    public function __construct($table, $pattern = null)
    {
        $this->pattern = $pattern;
        $this->table = $table;
    }
    public static function getInstance($name = '', $pattern = null): self
    {
        static $oldName = '';
        if ($oldName != $name) {
            $name = strtolower($name);
            $prefix = env('database.prefix', 'ba_');
            $tableName = "cms_$name";
            $table = $prefix . $tableName;
            self::$instance = new self($table);
            $oldName = $name;
        }
        self::$instance->pattern = $pattern;
        return self::$instance;
    }

    /**
     * @param string $exec
     * @param string $sql
     * @return bool|array
     * @throws Exception
     */
    private function run(string $exec, string $sql): bool|array
    {
        if (!in_array($exec, ['query', 'execute'])) throw new Exception("执行方法错误！");
        return \think\facade\Db::$exec($sql);
    }

    /**
     * @return bool|null
     * @throws Exception
     */
    public function tableExists(): bool|array
    {
        return $this->run('execute',"SHOW TABLES LIKE '{$this->table}'");
    }

    public static function createTable($name)
    {

    }
    /* ####################################################### 常用字段类型 ###################################################### */
    /* ======================================================== 数字类型 ===================================================== */
    // int 整型
    public function _int($args = [], $comment = ''): string
    {
        $default = NULL;
        extract($args);
        $maxlength = $this->getLength('int', $maxlength ?? 11);
        if ($default === NULL) $default = "DEFAULT NULL";
        else $default = "NOT NULL DEFAULT '$default'";
        if (!empty($comment)) $comment = "COMMENT '$comment'";
        return "INT( $maxlength ) $default $comment";
    }
    // float 浮点数
    // double 双精度浮点数
    // tinyint 小整型
    // smallint 小整型
    // bigint 长整型
    // decimal 定点数
    // mediumint 中等整型
    /* ======================================================= 日期和时间类型 ==================================================== */
    // datetime 日期时间
    // timestamp 时间戳
    // date 日期
    // time 时间
    // year 年份
    /* ======================================================== 字符串类型 ===================================================== */
    // enum 枚举
    // longtext 长文本
    // varchar 可变字符串
    // text 文本
    // mediumtext 中等文本
    // char 字符串
    /* ======================================================= 特殊数据类型 ===================================================== */
    // blob 二进制大对象
    // binary 二进制
    // bit 位
    // geometry 几何
    // geometrycollection 几何集合
    // integer 整型
    // json JSON
    // linestring 线
    // longblob 长二进制
    // mediumblob 中等二进制
    // multilinestring 多线
    // multipoint 多点
    // multipolygon 多面
    // numeric 定点数
    // point 点
    // polygon 面
    // real 浮点数
    // set 集合
    // tinyblob 小二进制
    // tibytext 小文本
    // varbinary 可变二进制

    /* ####################################################### 辅助方法 ###################################################### */

    private function getLength($type, $length): int
    {
        $length = (int)$length;
        switch ($type) {
            case 'varchar':
                if ($length <= 0) $length = 255;
                else if ($length > 65535) $length = 65535;
                break;
            case 'int':
                if ($length <= 0) $length = 1;
                else if ($length > 11) $length = 11;
                break;
        }
        return $length;
    }
}