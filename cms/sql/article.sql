-- 创建文章数据表
CREATE TABLE `final_article` (
  `aid` INT(10) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `cate_id` TINYINT NOT NULL DEFAULT 1 COMMENT '文章分类ID',
  `title` VARCHAR(100) NOT NULL DEFAULT '' COMMENT '文章标题',
  `cover_img` VARCHAR(100) NOT NULL DEFAULT '' COMMENT '文章封面图',
  `subtitle` VARCHAR(100) NOT NULL DEFAULT '' COMMENT '文章副标题',
  `keywords` VARCHAR(50) NOT NULL DEFAULT '' COMMENT '文章关键词',
  `descs` VARCHAR(255) NOT NULL DEFAULT '' COMMENT '文章简介', 
  `author` VARCHAR(40) NOT NULL DEFAULT '' COMMENT '文章作者',
  `status` TINYINT NOT NULL DEFAULT 1 COMMENT '文章状态 1 表示已发布 2 表示未发布',
  `is_hidden` TINYINT NOT NULL DEFAULT 1 COMMENT '文章是否公开 1 表示公开 2 表示仅自己可见',
  `is_delete` TINYINT NOT NULL DEFAULT 1 COMMENT '文章删除 1 表示文章正常 2 表示删除',
  `created_at` INT(10) NOT NULL DEFAULT 0 COMMENT '文章创建日期',
  `updated_at` INT(10) NOT NULL DEFAULT 0 COMMENT '文章修改日期',
  PRIMARY KEY (`aid`), 
)ENGINE=InnoDB DEFAULT charset=utf8;

-- 创建文章内容数据表
CREATE TABLE `final_article_content` (
  `cid` INT(10) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `aid` INT(10) NOT NULL DEFAULT 0 COMMENT '文章ID',
  `content` TEXT NOT NULL COMMENT '文章内容',
  `created_at` INT(10) NOT NULL DEFAULT 0 COMMENT '文章创建日期',
  `updated_at` INT(10) NOT NULL DEFAULT 0 COMMENT '文章修改日期',
  PRIMARY KEY (`cid`)
)ENGINE=InnoDB DEFAULT charset=utf8;
