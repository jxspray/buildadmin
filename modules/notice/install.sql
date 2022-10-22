CREATE TABLE IF NOT EXISTS `__PREFIX__notice`
(
    `id`         int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
    `title`      varchar(200) CHARACTER SET utf8mb4 NOT NULL DEFAULT '' COMMENT '标题',
    `type`       tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '类型:0=公告,1=通知',
    `content`    text COMMENT '内容',
    `weigh`      int(10) NOT NULL DEFAULT '0' COMMENT '权重',
    `updatetime` int(10) unsigned DEFAULT NULL COMMENT '更新时间',
    `createtime` int(10) unsigned DEFAULT NULL COMMENT '创建时间',
    PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8mb4 COMMENT='通知公告表';