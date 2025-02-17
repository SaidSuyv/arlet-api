DROP TABLE IF EXISTS `user`;
DROP TABLE IF EXISTS `role`;
DROP TABLE IF EXISTS `token`;

CREATE TABLE IF NOT EXISTS `user` (
	`id` int AUTO_INCREMENT NOT NULL UNIQUE,
	`name` varchar(255) NOT NULL,
	`lastname` varchar(255) NOT NULL,
	`username` varchar(255) NOT NULL,
	`email` varchar(255) NOT NULL,
	`pwd` text NOT NULL,
	`b_archive` tinyint NOT NULL DEFAULT '0',
	`f_role` int default NULL,
	PRIMARY KEY (`id`)
);

CREATE TABLE IF NOT EXISTS `role` (
	`id` int AUTO_INCREMENT NOT NULL UNIQUE,
	`name` varchar(255) NOT NULL,
	`b_archive` tinyint NOT NULL DEFAULT '0',
	PRIMARY KEY (`id`)
);

CREATE TABLE IF NOT EXISTS `token` (
	`id` int AUTO_INCREMENT NOT NULL UNIQUE,
	`t` text NOT NULL,
	PRIMARY KEY (`id`)
);

ALTER TABLE `user` ADD CONSTRAINT `user_fk6` FOREIGN KEY (`f_role`) REFERENCES `role`(`id`);

INSERT INTO role( name ) VALUES("admin");