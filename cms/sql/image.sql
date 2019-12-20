CREATE TABLE `final_image` (
  `img_id` INT(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `title` VARCHAR(100) NOT NULL DEFAULT '' COMMENT '图片名称',
  `user_id` INT(10) NOT NULL DEFAULT 1 COMMENT '图片作者',
  `url` VARCHAR(100) NOT NULL DEFAULT '' COMMENT '图片存储路径',
  `status` TINYINT NOT NULL DEFAULT 1 COMMENT '图片状态 1 表示已发布 2 表示未发布',
  `is_hidden` TINYINT NOT NULL DEFAULT 1 COMMENT '图片是否公开 1 表示公开 2 表示仅自己可见',
  `is_delete` TINYINT NOT NULL DEFAULT 1 COMMENT '图片删除 1 表示文章正常 2 表示删除',
  `created_at` INT(10) NOT NULL DEFAULT 0 COMMENT '图片创建日期',
  `updated_at` INT(10) NOT NULL DEFAULT 0 COMMENT '图片修改日期',
  PRIMARY KEY (`img_id`)
) ENGINE=InnoDB DEFAULT charset=utf8;