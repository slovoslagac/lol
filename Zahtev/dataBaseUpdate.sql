CREATE TABLE IF NOT EXISTS `lol`.`BonusHours` (
  `id` INT(5) NOT NULL AUTO_INCREMENT,
  `numHours` INT(3) NOT NULL,
  `SLuserId` INT(11) NULL DEFAULT NULL,
  `monthNum` INT(3) NULL DEFAULT NULL,
  UNIQUE KEY `uniqcalculation` (`numHours`,`SLuserId`,`monthNum`),
  KEY `porind` (`id`)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;

------------------


ALTER TABLE `lol`.`users`
ADD COLUMN `SLuserId` INT(11) NULL DEFAULT NULL AFTER `creditstatus`;


---------------------------

ALTER TABLE `lol`.`users`
CHANGE COLUMN `rankid` `rankid` INT(5) NULL DEFAULT NULL ,
ADD COLUMN `lolKlub` INT(1) NULL DEFAULT NULL AFTER `SLuserId`;

ALTER TABLE `lol`.`users`
DROP FOREIGN KEY `rankid`;

ALTER TABLE `lol`.`users` ADD CONSTRAINT `rankid`
  FOREIGN KEY (`rankid`)
  REFERENCES `lol`.`ranks` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;

------------------------------

ALTER TABLE `lol`.`users`
DROP INDEX `unuser` ,
ADD UNIQUE INDEX `unuser` (`arenausername` ASC, `SLuserId` ASC);