/*
 CMS Install SQL
 Date: 2022-10-12
*/
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for `__PREFIX__cms_catalog`
-- ----------------------------
CREATE TABLE `__PREFIX__cms_catalog`
(
    `id`              int(11)      NOT NULL AUTO_INCREMENT,
    `pid`             int(11)      NOT NULL COMMENT '上级栏目',
    `title`           varchar(255) NOT NULL COMMENT '名称',
    `description`     varchar(255) NOT NULL COMMENT '描述',
    `template_list`   varchar(50)  NOT NULL COMMENT '列表页面',
    `template_info`   varchar(50)  NOT NULL COMMENT '详情页|单页',
    `seo_url`         varchar(255) NOT NULL COMMENT '目录链接',
    `seo_title`       varchar(255) NOT NULL COMMENT '页面标题',
    `seo_keywords`    varchar(255) NOT NULL COMMENT '页面关键字',
    `seo_description` varchar(255) NOT NULL COMMENT '页面描述',
    `links_type`      enum ('0','1')         DEFAULT '0' COMMENT '自定义链接:0=默认,1=指定',
    `links_value`     text         NOT NULL COMMENT '连接页面(json对象，存在不同的类型)',
    `weigh`           int(5)       NOT NULL COMMENT '权重',
    `module`          varchar(50)  NOT NULL COMMENT '模型',
    `module_id`       int(11)                DEFAULT NULL COMMENT '模型ID 0为单页',
    `blank`           enum ('0','1')         DEFAULT '0' COMMENT '新窗口打开:0=否,1=是',
    `show`            enum ('0','1','2','3') DEFAULT '1' COMMENT '显示位置:0=不显示,1=都显示,2=头部显示,3=底部显示',
    `status`          enum ('0','1')         DEFAULT '1' COMMENT '状态:0=关闭,1=正常',
    `updatetime`      bigint(20)             DEFAULT NULL COMMENT '更新时间',
    `createtime`      bigint(20)             DEFAULT NULL COMMENT '创建时间',
    `deletetime`      bigint(20)             DEFAULT NULL COMMENT '删除时间',
    PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB
  AUTO_INCREMENT = 2
  DEFAULT CHARSET = utf8mb4 COMMENT ='栏目管理';

-- ----------------------------
-- Records of __PREFIX__cms_catalog
-- ----------------------------
# BEGIN;
# INSERT INTO `__PREFIX__cms_catalog` VALUES (1, 0, 0, 1, '', '首页', '11', '[]', '', '', 'index', '', '', '', 0, '[]', 0, 'page', NULL, 0, 1, 1, 'cn', 1, 'template');
# INSERT INTO `__PREFIX__cms_catalog` VALUES (2, 0, 0, 1, '', '新闻', '', '[]', '', '', 'news', '', '', '', 0, '[]', 0, 'news', NULL, 0, 2, 1, 'cn', 1, 'template');
# INSERT INTO `__PREFIX__cms_catalog` VALUES (3, 0, 0, 1, '', '产品', '', '[]', '', '', 'product', '', '', '', 0, '[]', 0, 'product', NULL, 0, 2, 1, 'cn', 1, 'template');
# INSERT INTO `__PREFIX__cms_catalog` VALUES (4, 0, 0, 1, '', '下载', '', '[]', '', '', 'download', '', '', '', 0, '[]', 0, 'download', NULL, 0, 2, 1, 'cn', 1, 'template');
# INSERT INTO `__PREFIX__cms_catalog` VALUES (5, 0, 0, 1, '', '招聘', '', '[]', '', '', 'job', '', '', '', 0, '[]', 0, 'job', NULL, 0, 2, 1, 'cn', 1, 'template');
# INSERT INTO `__PREFIX__cms_catalog` VALUES (6, 0, 0, 1, '', '门店', '', '[]', '', '', 'address', '', '', '', 0, '[]', 0, 'address', NULL, 0, 2, 1, 'cn', 1, 'template');
# INSERT INTO `__PREFIX__cms_catalog` VALUES (7, 0, 0, 1, '', '团队', '123', '[]', '', '', 'team', '', '', '', 0, '[]', 0, 'team', NULL, 0, 2, 1, 'cn', 1, 'template');
# INSERT INTO `__PREFIX__cms_catalog` VALUES (8, 0, 0, 0, '', '关于我们', '1231', '', '', 'about', 'about', '', '', '', 0, '', 8, '', NULL, 0, 1, 1, '', 0, '');
# COMMIT;

-- ----------------------------
-- Table structure for `__PREFIX__cms_fields`
-- ----------------------------
CREATE TABLE `__PREFIX__cms_fields`
(
    `id`         int(10) unsigned                        NOT NULL AUTO_INCREMENT COMMENT 'ID',
    `module_id`  int(10)                                 NOT NULL DEFAULT '0' COMMENT '模型ID',
    `name`       varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '别名',
    `field`      varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '字段名',
    `remark`     varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '备注',
    `required`   tinyint(1) unsigned                     NOT NULL DEFAULT '1' COMMENT '必填:0=关,1=开',
    `tips`       varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '小贴士',
    `setup`      varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '扩展属性',
    `type`       varchar(255) COLLATE utf8mb4_unicode_ci          DEFAULT NULL COMMENT '字段类型',
    `weigh`      int(10)                                          DEFAULT '0' COMMENT '权重',
    `status`     tinyint(1) unsigned                     NOT NULL DEFAULT '1' COMMENT '状态:0=禁用,1=启用',
    `updatetime` bigint(20) unsigned                              DEFAULT NULL COMMENT '修改时间',
    `createtime` bigint(20) unsigned                              DEFAULT NULL COMMENT '创建时间',
    `comment`    varchar(255) COLLATE utf8mb4_unicode_ci          DEFAULT NULL COMMENT '字段备注',
    PRIMARY KEY (`id`)
) ENGINE = InnoDB
  AUTO_INCREMENT = 6
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_unicode_ci COMMENT ='字段管理';

-- ----------------------------
-- Table structure for `__PREFIX__cms_module`
-- ----------------------------
DROP TABLE IF EXISTS `__PREFIX__cms_module`;
CREATE TABLE `__PREFIX__cms_module`
(
    `id`          int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
    `name`        varchar(50)    DEFAULT NULL COMMENT '模型',
    `title`       varchar(255)   DEFAULT NULL COMMENT '模型名称',
    `description` varchar(255)   DEFAULT NULL COMMENT '模型描述',
    `type`        enum ('1','2') DEFAULT '1' COMMENT '类型:1=常规模型,2=模块模型',
    `issystem`    enum ('1','0') DEFAULT '1' COMMENT '系统:1=是,0=否',
    `issearch`    enum ('1','0') DEFAULT '1' COMMENT '搜索:1=允许,0=禁止',
    `listfields`  varchar(255)   DEFAULT NULL COMMENT '列表字段',
    `weigh`       int(5)         DEFAULT NULL COMMENT '权重',
    `template`    varchar(255)   DEFAULT NULL COMMENT '字段模板',
    `path`        varchar(255)   DEFAULT NULL COMMENT '路径地址',
    `status`      enum ('1','0') DEFAULT '1' COMMENT '状态:1=启用,0=禁用',
    `generate`    longtext COMMENT '生成器',
    `createtime`  int(11)        DEFAULT NULL COMMENT '创建时间',
    `updatetime`  int(11)        DEFAULT NULL COMMENT '更新时间',
    PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COMMENT='模型管理';

