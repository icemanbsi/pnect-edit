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