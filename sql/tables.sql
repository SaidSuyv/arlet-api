DROP TABLE IF EXISTS `user`;
DROP TABLE IF EXISTS `role`;
DROP TABLE IF EXISTS `client`;
DROP TABLE IF EXISTS `company`;

CREATE TABLE IF NOT EXISTS `user` (
	`id` int AUTO_INCREMENT NOT NULL UNIQUE,
	`name` text NOT NULL,
	`lastname` text NOT NULL,
	`username` text NOT NULL,
	`email` text NOT NULL,
	`b_archive` tinyint NOT NULL DEFAULT '0',
	`f_company` int NOT NULL,
	`f_role` int NOT NULL,
	`pwd` text NOT NULL,
  `b_new` tinyint NOT NULL DEFAULT '1',
	PRIMARY KEY (`id`)
);

CREATE TABLE IF NOT EXISTS `role` (
	`id` int AUTO_INCREMENT NOT NULL UNIQUE,
	`name` varchar(255) NOT NULL,
	`b_archive` tinyint NOT NULL DEFAULT '0',
	PRIMARY KEY (`id`)
);

CREATE TABLE IF NOT EXISTS `company` (
	`id` int AUTO_INCREMENT NOT NULL UNIQUE,
	`logo_path` text DEFAULT 'NULL',
	`trade_name` text NOT NULL,
	`tax_type` int NOT NULL,
	`tax_amount` int NOT NULL DEFAULT '0',
	`country_currency` int NOT NULL,
	`localization` text NOT NULL,
	`fiscal_address` text NOT NULL,
	`annex_facility` text NOT NULL,
	`email` text NOT NULL,
	`company_name` text NOT NULL,
	`ruc` text NOT NULL,
	`certificate_path` text,
	`certificate_pwd` text,
	`scnd_sunat_user` text NOT NULL,
	`scnd_sunat_pwd` text NOT NULL,
	`sunat_server` text NOT NULL,
	`consulting_website` text NOT NULL,
	PRIMARY KEY (`id`)
);

CREATE TABLE IF NOT EXISTS `client` (
	`id` int AUTO_INCREMENT NOT NULL UNIQUE,
	`name` text NOT NULL,
	`email` text NOT NULL,
	`id_number` int NOT NULL,
	`phone` text NOT NULL,
	`balance` text NOT NULL,
	`address` text NOT NULL,
	`b_archive` tinyint NOT NULL DEFAULT '0',
	`f_company` int NOT NULL,
	PRIMARY KEY (`id`)
);

ALTER TABLE `user` ADD CONSTRAINT `user_fk6` FOREIGN KEY (`f_company`) REFERENCES `company`(`id`);

ALTER TABLE `user` ADD CONSTRAINT `user_fk7` FOREIGN KEY (`f_role`) REFERENCES `role`(`id`);


ALTER TABLE `client` ADD CONSTRAINT `client_fk8` FOREIGN KEY (`f_company`) REFERENCES `company`(`id`);

DROP TABLE IF EXISTS `currency`;

CREATE TABLE IF NOT EXISTS `currency` (
	`id` int AUTO_INCREMENT NOT NULL UNIQUE,
	`country` varchar(100) NOT NULL,
	`currency` varchar(100) NOT NULL,
	`iso` varchar(3) NOT NULL,
	PRIMARY KEY (`id`)
);

ALTER TABLE `company` ADD CONSTRAINT `company_fk5` FOREIGN KEY (`country_currency`) REFERENCES `currency`(`id`);