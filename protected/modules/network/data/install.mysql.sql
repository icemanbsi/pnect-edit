DROP TABLE IF EXISTS `{{NetworkFollowBoard}}`;
CREATE TABLE `{{NetworkFollowBoard}}` (
	`id`				bigint unsigned not null auto_increment,
	`boardId`			bigint unsigned,
	`userId`			bigint unsigned,
	primary key(`id`)
) engine = MyISAM CHARACTER SET utf8 COLLATE utf8_unicode_ci;

DROP TABLE IF EXISTS `{{NetworkFollowUser}}`;
CREATE TABLE `{{NetworkFollowUser}}` (
	`id`				bigint unsigned not null auto_increment,
	`followUserId`		bigint unsigned,
	`userId`			bigint unsigned,
	primary key(`id`)
) engine = MyISAM CHARACTER SET utf8 COLLATE utf8_unicode_ci;

DROP TABLE IF EXISTS `{{NetworkEvent}}`;
CREATE TABLE `{{NetworkEvent}}` (
	`id`				bigint unsigned not null auto_increment,
	`userId`			bigint unsigned,
	`eventModule`		varchar(250),
	`eventType`			varchar(250),
	`created`			bigint unsigned,
	`params`			varchar(250),
	primary key(`id`)
) engine = MyISAM CHARACTER SET utf8 COLLATE utf8_unicode_ci;

DROP TABLE IF EXISTS `{{NetworkInvite}}`;
CREATE TABLE `{{NetworkInvite}}` (
	`id`				bigint unsigned not null auto_increment,
	`userId`			bigint unsigned,
	`email`				varchar(250),
	`hash`				varchar(250),
	`created`			bigint unsigned,
	primary key(`id`)
) engine = MyISAM CHARACTER SET utf8 COLLATE utf8_unicode_ci;

DROP TABLE IF EXISTS `{{NetworkRequest}}`;
CREATE TABLE `{{NetworkRequest}}` (
	`id`				bigint unsigned not null auto_increment,
	`email`				varchar(250),
	`created`			bigint unsigned,
	primary key(`id`),
	unique(`email`)
) engine = MyISAM CHARACTER SET utf8 COLLATE utf8_unicode_ci;