DROP TABLE IF EXISTS `{{User}}`;
CREATE TABLE `{{User}}` (
	`id`				bigint unsigned not null auto_increment,
	`email`				varchar(250),
	/* salted-md5-encrypted password */
	`password`			varchar(32),
	/* password salt */
	`salt`				char(3),
	/* 0 - nothing, 1 - user password needs to be updated */
	`changePassword`	tinyint unsigned,
	`role`				varchar(50) not null default 'user',
	`created`			bigint unsigned,
	`firstName`			varchar(250),
	`lastName`			varchar(250),
	`username`			varchar(250),
	`avatar`			bigint unsigned,
	`timeZone`			double default 0,
	`ip`				varchar(250),
	`language`			varchar(10),
	`about`				text,	
	
	primary key (`id`),
	unique(`email`),
	unique(`username`)
) engine = MyISAM CHARACTER SET utf8 COLLATE utf8_unicode_ci ;

DROP TABLE IF EXISTS `{{UserNotify}}`;
CREATE TABLE `{{UserNotify}}` (
	`id`		bigint unsigned,
	`comment`	tinyint unsigned default 1,
	`like`		tinyint unsigned default 1,
	`repost`	tinyint unsigned default 1,
	`follow`	tinyint unsigned default 1,
	`unfollow`	tinyint unsigned default 1,
	primary key(`id`)
) engine = MyISAM CHARACTER SET utf8 COLLATE utf8_unicode_ci;