<?php

namespace ba\cms\utils;

use Exception;

class Sql
{
    private static self $instance;
    private string $pattern;
    private string $table;

    private array $fields = [];

    const CREATE_MODE = 'CREATE';
    const ALTER_MODE = 'ALTER';
    const DROP_MODE = 'DROP';
    const BUILD_MODE = 'BUILD';

    /**
     * 载入SQL类型处理实例
     */
    use \ba\cms\traits\form\FieldType;

    /**
     * 载入字段类型处理实例
     */
    use \ba\cms\traits\form\FormatType;

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
     * @return bool|string
     * @throws Exception
     */
    private function getTypeResult(array $data, array $originData = [], array $checkChange = []): bool|string
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
            return "{$this->getHead($data['field'], $originData['field']??'')} {$this->{$data['type']}($data)}";
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
        $data = $this->generateRowData($data);
        if (!$this->tableExists()) return false;
        $checkChange = ['field', 'setup', 'comment'];
        $res = $originData ? $this->getTypeResult($data, $originData, $checkChange) : $this->getTypeResult($data);
        if (!$res) return false;
        $this->run('execute', $this->generateQuery("ALTER", array_merge([
            'sql' => $res
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

    private function getLength($type, $setup): int
    {
        // 设置数据库字段长度
        if (!in_array($type, ['text', 'image', 'select', 'remoteSelect'])) return 0;
        if (in_array($type, ['image', 'file'])) return 255;
        $attrType = match ($setup['type']) {
            'key' => 'number',
            'keyValue' => 'string',
            default => $setup['type'] ?? 'text',
        };
        $attrList = [
            'number' => [1, 11, 11],
            'string' => [1, 65535, 100],
            'password' => [1, 65535, 20],
            'textarea' => [1, 65535, 255],
        ];
        extract($setup);
        $length = $length ?? 0;
        $attr = $attrList[$attrType];
        if ($length < $attr['0']) $length = $attr['2'];
        else if ($length > $attr['1']) $length = $attr['1'];
        return $length;
    }

    /**
     * @param $moduleRow
     * @return true
     * @throws Exception
     */
    public function createTable($moduleRow): bool
    {
        // 创建初始表
        $this->run("query", "{$this->getTableHead('CREATE')} (
            `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
            `weigh` int(5) NULL DEFAULT 0 COMMENT '排序',
            `lang` tinyint(1) NULL DEFAULT 0 COMMENT '语言ID',
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COMMENT='{$moduleRow['title']}'", true);
        // 创建字段表
//        self::$instance->pattern = 'ALTER';
        $this->createField($moduleRow);
        return true;
    }

    /**
     * @param array $moduleRow
     * @return bool
     * @throws Exception
     */
    protected function createField(array $moduleRow): bool
    {
        $data = [];
        switch ($moduleRow['template']) {
            case 'article':
                $data = [
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
                $data = [
                    ['name' => '状态', 'field' => 'status', 'type' => 'radio', 'setup' => [
                            'type' => 'key',
                            'options' => ['关闭', '开启']
                        ]
                    ],
                ];
                break;
        }
        foreach ($data as &$datum) {
            $datum['module_id'] = $moduleRow['id'];
            $datum = $this->generateRowData($datum);
        }
        (new \app\admin\model\cms\Fields)->saveAll($data);
        return true;
    }

    /**
     * @return bool
     * @throws Exception
     */
    public function deleteTable(): bool
    {
        return $this->tableExists() && $this->run('execute', $this->getTableHead('DROP'), true);
    }

    /* ####################################################### 辅助方法 ###################################################### */

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
//            'CREATE' => "DROP TABLE IF EXISTS `{$this->table}`; CREATE TABLE `$this->table` ",
            'CREATE' => "CREATE TABLE `$this->table` ",
            'ALTER' => "ALTER TABLE `$this->table`",
            'DROP' => "DROP TABLE IF EXISTS `{$this->table}`",
            default => throw new Exception("类型错误！"),
        };
    }

    private function generateQuery(string $mode, array|string $args = null): string
    {
        switch ($mode) {
            case self::ALTER_MODE:
                $args = array_merge([
                    'sql' => NULL,
                    'name' => '',
                    'comment' => '',
                ], $args);
                extract($args);
                if (empty($sql)) throw new Exception("SQL语句不能为空！");

                // 无需默认值类型
                if (in_array($args['type'], ['text'])) $default = '';
                else $default = "NOT NULL";

                if (!empty($name)) $comment = "COMMENT '$name'";
                return "ALTER TABLE `$this->table` {$sql} {$default} {$comment}";
            case self::DROP_MODE:
                return "DROP TABLE IF EXISTS `{$this->table}`";
            case self::BUILD_MODE:
                break;
            default:
                throw new Exception("类型错误！");
        }
        return '';
    }

    private function generateRowData($data): array
    {
        static $fieldData = [];
        if (empty($fieldData)) $fieldData = config('cms.param.fields');
        $data = array_merge($fieldData, $data);

        static $setupData = [];
        if (empty($setupData)) {
            foreach (config('cms.param.typeOptions') as $item) {
                $setupData[$item['value']] = $item['setup'];
            }
        }
        $data['setup'] = array_merge($setupData[$data['type']] ?? [], $data['setup'] ?? []);
        if ($length = $this->getLength($data['type'], $data['setup'])) $data['setup']['length'] = $length;
        return $data;
    }
}
