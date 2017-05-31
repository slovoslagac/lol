-----Ver 1.3--------

CREATE TABLE IF NOT EXISTS `lol`.`transactionallog` (
  `id` INT(5) NOT NULL AUTO_INCREMENT,
  `monthid` INT(9) NULL DEFAULT NULL,
  `logtype` INT(5) NULL DEFAULT NULL,
  `comment` VARCHAR(100) NULL DEFAULT NULL,
  `tstamp` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  INDEX `logindex` (`id` ASC))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;



ALTER TABLE `lol`.`transactionallog`
ADD UNIQUE INDEX `loguniq` (`monthid` ASC, `logtype` ASC);


-----Ver 1.2--------
-----------
CREATE TABLE IF NOT EXISTS `lol`.`bills` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `workerid` INT(5) NULL DEFAULT NULL,
  `userid` INT(9) NULL DEFAULT NULL,
  `billsum` float(6,2) DEFAULT NULL,
  `pricetype` varchar(45) DEFAULT NULL,
  `tstamp` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  INDEX `billsindex` (`id` ASC))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;

-----------------------------
CREATE TABLE IF NOT EXISTS `lol`.`billsrows` (
  `id` INT(5) NOT NULL AUTO_INCREMENT,
  `billrid` INT(5) NULL DEFAULT NULL,
  `numProducts` INT(2) NULL DEFAULT NULL,
  `sellingproductpriceid` INT(5) NULL DEFAULT NULL,
  `price` FLOAT(6,2) NULL DEFAULT NULL,
  `sellingproductid` int(5) DEFAULT NULL,
  INDEX `billsindex` (`id` ASC))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;







-----Ver 1.1--------
-----------
ALTER TABLE `lol`.`ranks`
ADD COLUMN `order` INT(2) NULL DEFAULT NULL AFTER `name`;
-------------------------

CREATE TABLE IF NOT EXISTS `lol`.`sellingproducts` (
  `id` INT(5) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(50) NOT NULL,
  `typeid` INT(5) NOT NULL,
  `create_time` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  INDEX `selporind` (`id` ASC),
  INDEX `fkselprodtype_idx` (`typeid` ASC),
  CONSTRAINT `fkprodtype0`
    FOREIGN KEY (`typeid`)
    REFERENCES `lol`.`producttype` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

-------------------------------

CREATE TABLE `sellingproductsprices` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `selingproductid` int(5) NOT NULL,
  `value` float(6,2) DEFAULT NULL,
  `pricetype` varchar(45) DEFAULT NULL,
  `create_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  UNIQUE KEY `uniqueprice` (`selingproductid`,`value`,`pricetype`),
  KEY `selporind` (`id`),
  KEY `fkslproductid_idx` (`selingproductid`),
  CONSTRAINT `fkslproductid` FOREIGN KEY (`selingproductid`) REFERENCES `sellingproducts` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-------------------------------

ALTER TABLE `lol`.`sellingproducts`
ADD UNIQUE INDEX `nametypeselprod` (`name` ASC, `typeid` ASC);

















-----Ver 1.0-------
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
ADD UNIQUE INDEX `unuser` (`arenausername` ASC, `SLuserId` ASC, `usertype` ASC);

-------------------------------------

ALTER TABLE `lol`.`users`
ADD COLUMN `usertype` INT(2) NOT NULL DEFAULT 1 AFTER `lolKlub`;

------------------------------------

ALTER TABLE `lol`.`users`
CHANGE COLUMN `SLuserId` `SLuserId` INT(11) NULL DEFAULT 0 ;