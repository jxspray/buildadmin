<?php
$uploadAllowFormat = [
    'image' => ['jpg', 'png', 'gif'],
    'file' => ['txt', 'pdf', 'crt'],
];
return [
    'param' => [
        'module' => [
            'name' => '',
            'title' => '',
            'description' => '',
            'type' => '1',
            'weigh' => '',
            'template' => '',
            'path' => '',
            'status' => '1',
        ],
        'fields' => [
            'module_id' => '',
            'name' => '',
            'field' => '',
            'remark' => '',
            'required' => '0',
            'tips' => '',
            'setup' => [],
            'type' => '',
            'weigh' => '',
            'status' => '1',
        ],
        'uploadAllowFormat' => $uploadAllowFormat,

        'typeOptions' => [
            'text' => ["group" => "common", "label" => "文本框", "value" => "text", "setting" => ["textType"], 'setup' => [
                'type' => 'string',
                'numSection' => '',
                'step' => 1,
                'linenum' => 1,
                'default' => '',
            ]],
            'radio' => ["group" => "common", "label" => "单选按钮", "value" => "radio", "setting" => ["select"], 'setup' => [
                'type' => 'key',
                'options' => ['关闭', '开启']
            ]],
            'checkbox' => ["group" => "common", "label" => "复选框", "value" => "checkbox", "setting" => ["select", "selectNum"], 'setup' => [
                'type' => 'key',
                'options' => [],
                'maxSelect' => 3,
            ]],
            'select' => ["group" => "common", "label" => "下拉框", "value" => "select", "setting" => ["select"], 'setup' => [
                'type' => 'key',
                'options' => [],
                'maxSelect' => 1,
            ]],
            'selects' => ["group" => "common", "label" => "下拉框(多选)", "value" => "selects", "setting" => ["select", "selectNum"], 'setup' => [
                'type' => 'key',
                'options' => [],
                'maxSelect' => 1,
            ]],

            'remoteSelect' => ["group" => "base", "label" => "远程下拉选择", "value" => "remoteSelect", "setting" => ["remoteSelect"], 'setup' => [
                'type' => 'key',
                'keyField' => 'id',
                'valueField' => 'name',
                'remoteName' => '',
            ]],
            'remoteSelects' => ["group" => "base", "label" => "远程下拉选择(多选)", "value" => "remoteSelects", "setting" => ["remoteSelect", "selectNum"], 'setup' => [
                'type' => 'key',
                'keyField' => 'id',
                'valueField' => 'name',
                'remoteName' => '',
                'maxSelect' => 1,
            ]],
            'datePicker' => ["group" => "base", "label" => "时间日期选择", "value" => "datePicker", "setting" => ["datePicker"], 'setup' => [
                'type' => 'datetime',
            ]],
            'city' => ["group" => "base", "label" => "城市选择", "value" => "city", "setting" => [], 'setup' => []],

            'image' => ["group" => "senior", "label" => "图片上传", "value" => "image", "setting" => ["upload", "image"], 'setup' => [
                'allowFormat' => $uploadAllowFormat['image'],
                'maxFileSize' => 1024,
                'maxHight' => 1920,
                'maxWidth' => 1080,
                'default' => ''
            ]],
            'images' => ["group" => "senior", "label" => "图片上传-多图", "value" => "images", "setting" => ["uploads", "image"], 'setup' => [
                'allowFormat' => $uploadAllowFormat['image'],
                'maxFileSize' => 1024,
                'maxUpload' => 3,
                'maxHight' => 1920,
                'maxWidth' => 1080,
                'default' => ''
            ]],
            'file' => ["group" => "senior", "label" => "文件上传", "value" => "file", "setting" => ["upload", "file"], 'setup' => [
                'allowFormat' => $uploadAllowFormat['file'],
                'maxFileSize' => 1024,
                'default' => ''
            ]],
            'files' => ["group" => "senior", "label" => "文件上传-多文件", "value" => "files", "setting" => ["uploads", "file"], 'setup' => [
                'allowFormat' => $uploadAllowFormat['file'],
                'maxFileSize' => 1024,
                'maxUpload' => 3,
                'default' => ''
            ]],
            'editor' => ["group" => "senior", "label" => "富文本编辑器", "value" => "editor", "setting" => ["editor"], 'setup' => [
                'autoThumb' => 0,
                'autoKeyword' => 0,
                'minShow' => 3,
                'autoDescription' => 0,
                'beforeNum' => '200',
                'default' => ''
            ]],
            // verify: { group: 'senior', label: '验证码', value: 'verify', setting: ['verify'], 'setup' => [] },
            'custom' => ["group" => "senior", "label" => "自定义多文本", "value" => "custom", "setting" => ["custom"], 'setup' => []],
            'tag' => ["group" => "senior", "label" => "标签", "value" => "tag", "setting" => ["tag"], 'setup' => []],
        ]
    ]
];