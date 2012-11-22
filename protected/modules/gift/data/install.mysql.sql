DROP TABLE IF EXISTS `{{Gift}}`;
CREATE TABLE `{{Gift}}` (
	`id`		bigint unsigned,
	`price`		double,
	primary key(`id`)
) engine = MyISAM CHARACTER SET utf8 COLLATE utf8_unicode_ci;

DROP TABLE IF EXISTS `{{GiftMenu}}`;
CREATE TABLE `{{GiftMenu}}` (
	`id`				bigint unsigned not null auto_increment,
	`priceStart`		double, 
	`priceEnd`			double,
	primary key(`id`)
) engine = MyISAM CHARACTER SET utf8 COLLATE utf8_unicode_ci;