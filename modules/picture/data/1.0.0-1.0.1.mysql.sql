DROP TABLE IF EXISTS `{{PictureCommentReport}}`;
CREATE TABLE `{{PictureCommentReport}}` (
	`id`				bigint unsigned not null auto_increment,
	`commentId`			bigint unsigned,
	`userId`			bigint unsigned,
	`reportType`		varchar(25),
	primary key(`id`)
) engine = MyISAM CHARACTER SET utf8 COLLATE utf8_unicode_ci;