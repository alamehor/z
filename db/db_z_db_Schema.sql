--
-- Database: `z_db`
--

CREATE DATABASE IF NOT EXISTS `z_db`;
USE `z_db`;


-- ENTITIES

--
-- Struttura della tabella `article`
--

CREATE TABLE IF NOT EXISTS `article` (
	`Description` varchar(130)  NOT NULL,
	`Img` varchar(130) ,
	`Tag` varchar(130) ,
	`Title` varchar(130)  NOT NULL,
	`seoDescription` varchar(130)  NOT NULL,
	`seoImg` varchar(130) ,
	`seoKey` varchar(130) ,
	`seoTitle` varchar(130)  NOT NULL,
	
	`_id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT 

);


--
-- Struttura della tabella `media`
--

CREATE TABLE IF NOT EXISTS `media` (
	`Description` varchar(130)  NOT NULL,
	`Name` varchar(130)  NOT NULL,
	`Title` varchar(130)  NOT NULL,
	`seoDescription` varchar(130)  NOT NULL,
	`seoTitle` varchar(130)  NOT NULL,
	
	`_id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT 

);


--
-- Struttura della tabella `user`
--

CREATE TABLE IF NOT EXISTS `user` (
	`mail` varchar(130) ,
	`name` varchar(130) ,
	`password` varchar(130)  NOT NULL,
	`roles` varchar(130) ,
	`surname` varchar(130) ,
	`username` varchar(130)  NOT NULL,
	
	`_id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT 

);


-- Security

ALTER TABLE `user` MODIFY COLUMN `password` varchar(128)  NOT NULL;

INSERT INTO `z_db`.`user` (`username`, `password`, `_id`) VALUES ('admin', '62f264d7ad826f02a8af714c0a54b197935b717656b80461686d450f7b3abde4c553541515de2052b9af70f710f0cd8a1a2d3f4d60aa72608d71a63a9a93c0f5', 1);

CREATE TABLE IF NOT EXISTS `roles` (
	`role` varchar(30) ,
	
	-- RELAZIONI

	`_user` int(11)  NOT NULL REFERENCES user(_id),
	`_id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT 

);
INSERT INTO `z_db`.`roles` (`role`, `_user`, `_id`) VALUES ('ADMIN', '1', 1);





-- relation 1:m User Media - User
ALTER TABLE `media` ADD COLUMN `User` int(11)  REFERENCES user(_id);

-- relation m:m Article Media - Article
CREATE TABLE IF NOT EXISTS `Media_Article` (
    `_id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `id_Media` int(11)  NOT NULL REFERENCES media(_id),
    `id_Article` int(11)  NOT NULL REFERENCES article(_id)
);


