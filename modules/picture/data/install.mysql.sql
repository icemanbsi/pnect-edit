DROP TABLE IF EXISTS `{{Picture}}`;
CREATE TABLE `{{Picture}}` (
	`id`				bigint unsigned not null auto_increment,
	`bin`				bigint unsigned,
	`userId`			bigint unsigned,
	`height`			int unsigned,
	`created`			bigint unsigned,
	primary key(`id`),
	index(`userId`)
) engine = MyISAM CHARACTER SET utf8 COLLATE utf8_unicode_ci;

DROP TABLE IF EXISTS `{{PicturePost}}`;
CREATE TABLE `{{PicturePost}}` (
	`id`				bigint unsigned not null auto_increment,
	`pictureId`			bigint unsigned,
	`parentId`			bigint unsigned,
	`userId`			bigint unsigned,
	`boardId`			bigint unsigned,
	`source`			varchar(250),
	`sourceDomain`		varchar(250),
	`channel`			varchar(20),
	`message`			text,
	`likes`				bigint unsigned,
	`reposts`			bigint unsigned,
	`comments`			bigint unsigned,
	`created`			bigint unsigned,
	primary key(`id`),
	index(`sourceDomain`),
	index(`boardId`)
) engine = MyISAM CHARACTER SET utf8 COLLATE utf8_unicode_ci;

DROP TABLE IF EXISTS `{{PictureCategory}}`;
CREATE TABLE `{{PictureCategory}}` (
	`id`				bigint unsigned not null auto_increment,
	`url`				varchar(250),
	`image`				bigint unsigned,
	`enabled`			tinyint unsigned,
	primary key(`id`)
) engine = MyISAM CHARACTER SET utf8 COLLATE utf8_unicode_ci;

DROP TABLE IF EXISTS `{{PictureComment}}`;
CREATE TABLE `{{PictureComment}}` (
	`id`				bigint unsigned not null auto_increment,
	`postId`			bigint unsigned,
	`userId`			bigint unsigned,
	`text`				text,
	`created`			bigint unsigned,
	primary key(`id`),
	index(`postId`)
) engine = MyISAM CHARACTER SET utf8 COLLATE utf8_unicode_ci;

DROP TABLE IF EXISTS `{{PictureLike}}`;
CREATE TABLE `{{PictureLike}}` (
	`id`				bigint unsigned not null auto_increment,
	`postId`			bigint unsigned,
	`userId`			bigint unsigned,
	`created`			bigint unsigned,
	primary key(`id`)
) engine = MyISAM CHARACTER SET utf8 COLLATE utf8_unicode_ci;

DROP TABLE IF EXISTS `{{PictureReport}}`;
CREATE TABLE `{{PictureReport}}` (
	`id`				bigint unsigned not null auto_increment,
	`postId`			bigint unsigned,
	`userId`			bigint unsigned,
	`reportType`		varchar(25),
	primary key(`id`)
) engine = MyISAM CHARACTER SET utf8 COLLATE utf8_unicode_ci;

DROP TABLE IF EXISTS `{{PictureCommentReport}}`;
CREATE TABLE `{{PictureCommentReport}}` (
	`id`				bigint unsigned not null auto_increment,
	`commentId`			bigint unsigned,
	`userId`			bigint unsigned,
	`reportType`		varchar(25),
	primary key(`id`)
) engine = MyISAM CHARACTER SET utf8 COLLATE utf8_unicode_ci;