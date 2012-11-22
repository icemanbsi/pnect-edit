DROP TABLE IF EXISTS `{{Board}}`;
CREATE TABLE `{{Board}}` (
	`id`				bigint unsigned not null auto_increment,
	`userId`			bigint unsigned,
	`categoryId`		bigint unsigned,
	`title`				varchar(250),
	`url`				varchar(250),
	`description`		text,
	`access`			tinyint unsigned,
	`cover`				bigint unsigned,
	`sortOrder`			bigint unsigned default 0,
	primary key(`id`)
) engine = MyISAM CHARACTER SET utf8 COLLATE utf8_unicode_ci;

DROP TABLE IF EXISTS `{{BoardUser}}`;
CREATE TABLE `{{BoardUser}}` (
	`id`				bigint unsigned not null auto_increment,
	`boardId`			bigint unsigned,
	`userId`			bigint unsigned,
	primary key(`id`)
) engine = MyISAM CHARACTER SET utf8 COLLATE utf8_unicode_ci;
