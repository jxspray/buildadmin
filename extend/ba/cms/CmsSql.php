<?php

namespace ba\cms;

use Exception;

class CmsSql
{
    private static self $instance;
    private string $pattern;
    private string $table;

    private array $fields = [];

    const CREATE_MODE = 'CREATE';
    const ALTER_MODE = 'ALTER';
    const DROP_MODE = 'DROP';
    const BUILD_MODE = 'BUILD';

    public function __construct($table, $pattern = 'CREATE')
    {
        $this->pattern = $pattern;
        $this->table = $table;

    }

    /**
     * 获取sql和setup
     * @param array $data
     * @param array $originData
     * @param array $checkChange
     * @return bool|array
     * @throws Exception
     */
    public function getTypeResult(array $data, array $originData = [], array $checkChange = []): bool|array
    {
        static $setupData = [];
        if (empty($setupData)) {
            foreach (config('cms.param.typeOptions') as $item) {
                $setupData[$item['value']] = $item['setup'];
            }
        }
        $data = array_merge([
            'setup' => [],
            'remark' => NULL,
        ], $data);
        if ($checkChange) {
            $bool = false;
            foreach ($checkChange as $field) {
                if ($data[$field] != $originData[$field]) {
                    $bool = true;
                    break;
                }
            }
            if ($bool === false) return false;
        }
        if (method_exists($this, $data['type'])) {
            $data['setup'] = array_merge($setupData[$data['type']] ?? [], $data['setup'] ?? []);
            list($sql, $setup, $type) = $this->{$data['type']}($data);
            $data['setup'] = $setup;
            return ["{$this->getHead($data['field'], $originData['field']??'')} {$sql}", $data, $type];
        }
        return false;
    }

    /**
     * @param array $data
     * @param array|false $originData
     * @return bool
     * @throws Exception
     */
    public function saveField(array $data, array|false $originData = false): bool
    {
//        if (!$this->tableExists()) return false;
        $checkChange = ['field', 'setup', 'comment'];
        $res = $originData ? $this->getTypeResult($data, $originData, $checkChange) : $this->getTypeResult($data);
        if (!$res) return false;
        $this->run('execute', $this->generateQuery("ALTER", array_merge([
            'sql' => $res[0],
            'fieldType' => $res[2]
        ], $data)));
        return true;
    }

    /**
     * @param string $field
     * @return bool
     * @throws Exception
     */
    public function deleteField(string $field): bool
    {
        /* 检查字段是否存在 */
        if ($this->tableExists() && $this->fieldExists($field)) {
            $this->run("execute", "{$this->getTableHead('ALTER')} {$this->getHead($field, 'DROP')}");
            return true;
        }
        return false;
    }

    /**
     * @param $field
     * @return object|bool
     * @throws Exception
     */
    public function fieldExists($field): array|bool
    {
        if (empty($field)) return false;
        return $this->run("query", "DESC `{$this->table}` `$field`", true);
    }

    /**
     * @return bool|array
     * @throws Exception
     */
    public function tableExists(): bool|array
    {
        return $this->run('execute', "SHOW TABLES LIKE '{$this->table}'", true);
    }

    /**
     * @param $moduleRow
     * @return true
     * @throws Exception
     */
    public function createTable($moduleRow): bool
    {
        list($sql, $fieldList) = $this->createField($moduleRow);
        $fieldsModel = new \app\admin\model\cms\Fields();
//        foreach ($fieldList as $item) {
//            $fieldsModel->save($item);
//        }
        $fieldsModel->saveAll($fieldList);
        $this->run("query", "{$this->getTableHead('CREATE')} ($sql) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COMMENT='{$moduleRow['title']}'", true);
        return true;
    }

    /**
     * @param array $moduleRow
     * @return array
     * @throws Exception
     */
    protected function createField(array $moduleRow): array
    {
        $fieldList = [];
        $sqlList = [];
        switch ($moduleRow['template']) {
            case 'article':
                $fieldList = [
                    ['name' => '栏目', 'field' => 'catid', 'type' => 'remoteSelect', 'setup' => [
                            'type' => 'key',
                            'keyField' => 'id',
                            'valueField' => 'name',
                            'remoteName' => '',
                        ]
                    ],
                    ['name' => '标题', 'field' => 'title', 'type' => 'text', 'setup' => [
                            'type' => 'string',
                            'default' => '',
                        ]
                    ],
                    ['name' => '关键词', 'field' => 'keywords', 'type' => 'text', 'setup' => [
                            'type' => 'string',
                            'default' => '',
                        ]
                    ],
                    ['name' => '描述', 'field' => 'description', 'type' => 'text', 'setup' => [
                            'type' => 'textarea',
                            'linenum' => 3,
                            'default' => '',
                        ]
                    ],
                    ['name' => '状态', 'field' => 'status', 'type' => 'radio', 'setup' => [
                            'type' => 'key',
                            'options' => ['关闭', '开启']
                        ]
                    ],
                ];
                break;
            case 'empty':
                $fieldList = [
                    ['name' => '状态', 'field' => 'status', 'type' => 'radio', 'setup' => [
                            'type' => 'key',
                            'options' => ['关闭', '开启']
                        ]
                    ],
                ];
                break;
        }
        $sqlList[] = "`id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID'";
        $fieldData = config('cms.param.fields');
        foreach ($fieldList as $datum) {
            $datum = array_merge($fieldData, $datum);
            $datum['module_id'] = $moduleRow['id'];
            $res = $this->getTypeResult($datum);
            if ($res) {
                $sqlList[] = $res[0];
                $fieldList[] = $res[1];
            }
        }
        $sqlList[] = "`weigh` int(5) unsigned NOT NULL DEFAULT '0' COMMENT '排序'";
        $sqlList[] = "`lang` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '语言ID'";

        $sqlList[] = "PRIMARY KEY (`id`)";
        return [implode(", ", $sqlList), $fieldList];
    }

    public function assembleField(string $comment = NULL, string $default = NULL): array|string
    {
        if ($default === NULL) $default = "DEFAULT NULL";
        else $default = "NOT NULL DEFAULT '$default'";
        if (!empty($comment)) $comment = "COMMENT '$comment'";
        return "{$default} {$comment}";
    }

    /**
     * @return bool
     * @throws Exception
     */
    public function deleteTable(): bool
    {
        return $this->tableExists() && $this->run('execute', $this->getTableHead('DROP'), true);
    }

    /* ######################################################### 组件 ######################################################## */
    /**
     * @param array $data
     * @return array
     */
    public function text(array $data): array
    {
        extract($data);
        $setup = $setup ?? [];
        return [match ($setup['type'] ?? 'string') {
            "string", "textarea", "password" => $this->_varchar($setup),
            "number" => $this->_int($setup)
        }, $data, __FUNCTION__];
    }

    /**
     * @param array $data
     * @return array
     */
    public function select(array $data): array
    {
        extract($data);
        $setup = $setup ?? [];
        return [$this->_varchar($setup), $data, __FUNCTION__];
    }

    public function radio(array $setup): array
    {
        $setup = array_merge([], $setup);
        extract($setup);
        $setup = $setup ?? [];
        $setup['options'] = $setup['options'] ?? ['0' => '否', '1' => '是'];
        return [$this->_enum($setup), $data, __FUNCTION__];
    }

    /**
     * @param array $data
     * @return array
     */
    public function image(array $setup): array
    {
        $setup = array_merge([
            'allowFormat' => 'jpg,png,gif', // 允许上传格式
            'maxFileSize' => 1024, // 最大上传大小 单位KB
            'maxWidth' => 200, // 最大宽度
            'maxHeight' => 200, // 最大高度
        ], $setup);
        $res = $this->_varchar($setup);
        return [$res[0], $setup, $res[1]];
    }

    /**
     * @param array $data
     * @return array
     */
    public function remoteSelect(array $data): array
    {
        extract($data);
        $setup = $setup ?? [];
        return [$this->_int($setup), $data, __FUNCTION__];
    }

    public function editor(array $setup): array
    {
        $setup = array_merge([
            'autoThumb' => 0, // 自动抓取缩略图
            'autoKeyword' => 0, // 自动抓取关键词
            'minAppear' => 5, // 关键词至少出现次数
            'autoDescription' => 0, // 自动抓取描述
            'cutContentNum' => 200, // 截取内容前字数
        ], $setup);
        $res = $this->_text($setup);
        return [$res[0], $setup, $res[1]];
    }

    /* ####################################################### 常用字段类型 ###################################################### */
    /* ======================================================== 数字类型 ===================================================== */
    // int 整型
    public function _int($args = []): string
    {
        extract($args);
        $maxlength = $this->getLength('int', $maxlength ?? 11);
        return "INT( $maxlength )";
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
    // varchar 可变字符串
    private function _varchar($args = []): array
    {
        extract($args);
        $maxlength = $this->getLength('varchar', $maxlength ?? 0);
        return ["VARCHAR( $maxlength )", __FUNCTION__];
    }

    // enum 枚举
    private function _enum($args = []): string
    {
        extract($args);
        $options = array_keys($options);
        $str = '';
        foreach ($options as $option) {
            if ($str) $str .= ", ";
            $str .= "'$option'";
        }
        return "enum( $str )";
    }
    // longtext 长文本
    // text 文本
    private function _text($args = []): array
    {
        extract($args);
        return ["TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci", __FUNCTION__];
    }
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

    /**
     * @param string $exec
     * @param string $sql
     * @param bool $tryCatch
     * @return bool|array
     * @throws Exception
     */
    public function run(string $exec, string $sql, bool $tryCatch = false): bool|array
    {
        try {
            if (!in_array($exec, ['query', 'execute'])) throw new Exception("执行方法错误！");

            \think\facade\Log::sql("SQL: {$sql}; EXEC: {$exec}");
            return \think\facade\Db::$exec($sql);
        } catch (Exception $e) {
            if ($tryCatch) {
                \think\facade\Log::error("Msg: {$e->getMessage()}; File: {$e->getFile()}; Line: {$e->getLine()}");
                return false;
            }
            else throw $e;
        }
    }


    /* ####################################################### GET或SET方法 ###################################################### */
    /**
     * @return string
     */
    public function getPattern(): string
    {
        return $this->pattern;
    }

    /**
     * @param string $name
     * @param string $pattern
     * @return self
     */
    public static function getInstance(string $name = '', string $pattern = "CREATE"): self
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
     * @param string $field
     * @param string $originField
     * @return string
     * @throws Exception
     */
    public function getHead(string $field, string $originField = ''): string
    {
        if ($this->pattern == 'CREATE') return "`$field`";
        if ($originField == 'DROP') $do = "DROP";
        else {
            if (!empty($originField)) {
                $do = $this->fieldExists($originField) ? (($originField != $field) ? "CHANGE" : "MODIFY") : "ADD";
                /* 如果数据表原字段不存在，检查新字段是否存在 */
                if ($do == "ADD" && $this->fieldExists($field)) abort(405, "字段已存在");
                if ($do == "CHANGE") $field = "`$originField` `$field`";
            } else {
                $do = $this->fieldExists($field) ? "CHANGE COLUMN" : "ADD";
                $field = "`$field`";
            }
        }
        return "$do COLUMN $field";
    }

    private function getTableHead(string $type): string
    {
        return match ($type) {
            'CREATE' => "DROP TABLE IF EXISTS `{$this->table}`; CREATE TABLE `$this->table` ",
            'ALTER' => "ALTER TABLE `$this->table`",
            'DROP' => "DROP TABLE IF EXISTS `{$this->table}`",
            default => throw new Exception("类型错误！"),
        };
    }

    private function generateQuery(string $mode, array|string $args = null): string
    {
        switch ($mode) {
            case self::CREATE_MODE:
                $args = array_merge([
                    'sql' => null,
                    'comment' => '模型表',
                ], $args);
                extract($args);
                if (empty($sql)) throw new Exception("SQL语句不能为空！");

                $comment = $comment ? "COMMENT='{$comment}'" : '';
                return <<<SQL
DROP TABLE IF EXISTS `{$this->table}`; 
CREATE TABLE `{$this->table}` {$args['sql']} ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci $comment;
SQL;
            case self::ALTER_MODE:
                $args = array_merge([
                    'sql' => NULL,
                    'fieldType' => NULL,
                    'name' => '',
                    'default' => NULL,
                    'comment' => '',
                ], $args);
                extract($args);
                if (empty($sql)) throw new Exception("SQL语句不能为空！");
                if (empty($fieldType)) throw new Exception("字段类型不能为空！");
                if (empty($comment)) $comment = $name;
                // 无需默认值类型
                $noDefault = ['_text', '_mediumtext', '_longtext', '_blob', '_mediumblob', '_longblob', '_json', '_set'];
                if (in_array($fieldType, $noDefault)) $default = '';
                else {
                    if ($default === NULL) $default = "DEFAULT NULL";
                    else $default = "NOT NULL DEFAULT '$default'";
                }
                if (!empty($comment)) $comment = "COMMENT '$comment'";
                return "ALTER TABLE `$this->table` {$sql} {$default} {$comment}";
            case self::DROP_MODE:
                return "DROP TABLE IF EXISTS `{$this->table}`";
            case self::BUILD_MODE:
                break;
            default:
                throw new Exception("类型错误！");
        }
    }
}