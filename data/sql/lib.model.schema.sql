
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

#-----------------------------------------------------------------------------
#-- gare
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `gare`;


CREATE TABLE `gare`
(
	`id` INTEGER  NOT NULL,
	`nom` VARCHAR(255)  NOT NULL,
	`valide` TINYINT default 1 NOT NULL,
	PRIMARY KEY (`id`),
	UNIQUE KEY `gare_U_1` (`nom`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- ligne
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `ligne`;


CREATE TABLE `ligne`
(
	`id` INTEGER  NOT NULL,
	`nom` VARCHAR(255)  NOT NULL,
	`valide` TINYINT default 1 NOT NULL,
	PRIMARY KEY (`id`),
	UNIQUE KEY `ligne_U_1` (`nom`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- ligne_gare
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `ligne_gare`;


CREATE TABLE `ligne_gare`
(
	`ligne_id` INTEGER  NOT NULL,
	`gare_id` INTEGER  NOT NULL,
	`valide` TINYINT default 1 NOT NULL,
	PRIMARY KEY (`ligne_id`,`gare_id`),
	CONSTRAINT `ligne_gare_FK_1`
		FOREIGN KEY (`ligne_id`)
		REFERENCES `ligne` (`id`),
	INDEX `ligne_gare_FI_2` (`gare_id`),
	CONSTRAINT `ligne_gare_FK_2`
		FOREIGN KEY (`gare_id`)
		REFERENCES `gare` (`id`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- discussion
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `discussion`;


CREATE TABLE `discussion`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`ligne_id` INTEGER  NOT NULL,
	`nom` VARCHAR(255)  NOT NULL,
	`nombre_message` INTEGER default 0 NOT NULL,
	`importante` TINYINT default 0 NOT NULL,
	`valide` TINYINT default 1 NOT NULL,
	`created_at` DATETIME,
	`updated_at` DATETIME,
	PRIMARY KEY (`id`),
	UNIQUE KEY `discussion_U_1` (`nom`),
	INDEX `discussion_FI_1` (`ligne_id`),
	CONSTRAINT `discussion_FK_1`
		FOREIGN KEY (`ligne_id`)
		REFERENCES `ligne` (`id`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- message
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `message`;


CREATE TABLE `message`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`discussion_id` INTEGER  NOT NULL,
	`contenu` VARCHAR(255)  NOT NULL,
	`valide` TINYINT default 1 NOT NULL,
	`created_at` DATETIME,
	`updated_at` DATETIME,
	PRIMARY KEY (`id`),
	INDEX `message_FI_1` (`discussion_id`),
	CONSTRAINT `message_FK_1`
		FOREIGN KEY (`discussion_id`)
		REFERENCES `discussion` (`id`)
)Type=InnoDB;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
