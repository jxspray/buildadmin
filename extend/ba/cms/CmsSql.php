<?php

namespace ba\cms;

use Exception;

class CmsSql
{
    private static self $instance;
    private string $pattern;
    private string $table;

    private array $fields = [];

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
            list($sql, $setup) = $this->{$data['type']}($data);
            $sql = "{$this->getHead($data['field'], $originData['field']??'')} $sql {$this->assembleField($data['comment']??'', $data['default']??'')}";
            $data['setup'] = $setup;
            return [$sql, $data];
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
        if (!$this->tableExists()) return false;
        $checkChange = ['field', 'setup', 'comment'];
        $res = $originData ? $this->getTypeResult($data, $originData, $checkChange) : $this->getTypeResult($data);
        if (!$res) return false;
        $this->run('execute', "{$this->getTableHead('ALTER')} {$res[0]}");
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
        return $this->run('execute',"SHOW TABLES LIKE '{$this->table}'", true);
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
        $data = [];
        $fieldList = [];
        $sqlList = [];
        switch ($moduleRow['template']) {
            case 'article':
                $data['catid'] = $this->select(['field' => 'catid', 'remark' => '栏目', 'comment' => '栏目']);
                $data['title'] = $this->text(['field' => 'title', 'remark' => '标题', 'comment' => '标题']);
                $data['keywords'] = $this->text(['field' => 'keywords', 'remark' => '关键词', 'comment' => '关键词']);
                $data['description'] = $this->text(['field' => 'description', 'remark' => '描述', 'comment' => '描述']);
                $data['status'] = $this->radio(['field' => 'status', 'default' => 0, 'listorder' => 99, 'remark' => '状态', 'comment' => '状态']);
                break;
            case 'empty':
                $data['status'] = $this->radio(['default' => 0, 'listorder' => 99, 'remark' => '状态', 'comment' => '状态']);
                break;
        }
        $sqlList[] = "`id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID'";
        foreach ($data as $field => $datum) {
            $datum[1]['module_id'] = $moduleRow['id'];
            $datum[1]['type'] = $datum[1]['type'] ?? $datum[2];
            $fieldList[] = $datum[1];

            $sqlList[] = "{$this->getHead($field)} {$datum[0]} {$this->assembleField($datum[1]['comment']??'', $datum[1]['default']??'')}";
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
        return $this->tableExists() && $this->run('execute',$this->getTableHead('DROP'), true);
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
        return [match ($setup['type']??'string') {
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

    public function radio(array $data): array
    {
        extract($data);
        $setup = $setup ?? [];
        $setup['options'] = $setup['options'] ?? ['0' => '否', '1' => '是'];
        return [$this->_enum($setup), $data, __FUNCTION__];
    }
    /**
     * @param array $data
     * @return array
     */
    public function image(array $data): array
    {
        extract($data);
        $setup = $setup ?? [];
        return [$this->_varchar($setup), $data, __FUNCTION__];
    }

    public function editor(array $data): array
    {
        extract($data);
        $setup = $setup ?? [];
        return [$this->_text($setup), $data, __FUNCTION__];
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
    private function _varchar($args = []): string
    {
        extract($args);
        $maxlength = $this->getLength('varchar', $args['maxlength'] ?? 0);
        return "VARCHAR( $maxlength )";
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
    private function _text($args = []): string
    {
        extract($args);
        return "";
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
            return \think\facade\Db::$exec($sql);
        } catch (Exception $e) {
            \think\facade\Log::error("Msg: {$e->getMessage()}; File: {$e->getFile()}; Line: {$e->getLine()}");
            if ($tryCatch) return false;
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
            }
        }
        return "$do COLUMN `$field`";
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
}