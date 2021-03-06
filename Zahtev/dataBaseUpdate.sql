-----Ver 1.6--------
CREATE TABLE IF NOT EXISTS `lol`.`billsdetails` (
  `id` INT(5) NOT NULL AUTO_INCREMENT,
  `billrid` INT(5) NULL DEFAULT NULL,
  `safe` DECIMAL(6,0) NULL DEFAULT NULL,
  `deposit` DECIMAL(6,0) NULL DEFAULT NULL,
  `computers` DECIMAL(6,0) NULL DEFAULT NULL,
  `costs` decimal(6,0) DEFAULT NULL,
  `moneysum` DECIMAL(6,0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  INDEX `billsindex` (`id` ASC),
  INDEX `billfkid_idx` (`billrid` ASC),
  CONSTRAINT `billfkid0`
    FOREIGN KEY (`billrid`)
    REFERENCES `lol`.`bills` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci

ALTER TABLE `lol`.`billsdetails`
ADD COLUMN `comment` TEXT NULL DEFAULT NULL AFTER `moneysum`;

ALTER TABLE `lol`.`billsdetails`
CHANGE COLUMN `moneysum` `moneysum` DECIMAL(9,0) NULL DEFAULT NULL ;


CREATE TABLE IF NOT EXISTS `lol`.`billssum` (
  `id` INT(5) NOT NULL AUTO_INCREMENT,
  `billrid` INT(5) NULL DEFAULT NULL,
  `value` DECIMAL(9,0) NULL DEFAULT NULL,
  `type` INT(1) NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  INDEX `billsindex` (`id` ASC),
  INDEX `billfkid_idx` (`billrid` ASC),
  CONSTRAINT `billfkid00`
    FOREIGN KEY (`billrid`)
    REFERENCES `lol`.`bills` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;

CREATE TABLE IF NOT EXISTS `lol`.`billscommentar` (
  `id` INT(5) NOT NULL AUTO_INCREMENT,
  `billrid` INT(5) NULL DEFAULT NULL,
  `comment` TEXT NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  INDEX `billsindex` (`id` ASC),
  INDEX `billfkid_idx` (`billrid` ASC),
  CONSTRAINT `billfkid000`
    FOREIGN KEY (`billrid`)
    REFERENCES `lol`.`bills` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;


ALTER TABLE `lol`.`suppliers`
ADD COLUMN `type` INT(1) NULL DEFAULT NULL COMMENT '1 - spoljni izvor 2- interni magacin' AFTER `timestamp`


-----Ver 1.5--------


ALTER TABLE `lol`.`billsrows`
CHANGE COLUMN `numProducts` `numProducts` DECIMAL(6,2) NULL DEFAULT NULL ;

ALTER TABLE `lol`.`bills`
ADD PRIMARY KEY (`id`);


ALTER TABLE `lol`.`billsrows`
ADD PRIMARY KEY (`id`);

ALTER TABLE `lol`.`billsrows`
ADD COLUMN `type` INT(2) NULL DEFAULT NULL AFTER `sellingproductid`;

ALTER TABLE `lol`.`bills`
CHANGE COLUMN `billsum` `billsum` FLOAT(10,2) NULL DEFAULT NULL ;

CREATE TABLE `sonystats` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `expiretime` datetime NOT NULL,
  `tstamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `sonynum` int(2) NOT NULL,
  UNIQUE KEY `uniqsony` (`sonynum`),
  KEY `porind` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;




-----Ver 1.4--------


CREATE TABLE IF NOT EXISTS `lol`.`shifts` (
  `id` INT(5) NOT NULL AUTO_INCREMENT,
  `starttime` DATETIME NOT NULL,
  `endtime` DATETIME NULL DEFAULT NULL,
  `status` INT(1) NOT NULL,
  `userstart` INT(9) NULL DEFAULT NULL,
  `userend` INT(9) NULL DEFAULT NULL,
  INDEX `uniqueshift` (`id` ASC))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;


ALTER TABLE `lol`.`bills`
ADD COLUMN `type` INT(3) NULL DEFAULT NULL COMMENT '1 - regular bill\n2 - shift start\n3 - shift end\n4 - shift bill' AFTER `pricetype`;

ALTER TABLE `lol`.`shifts`
ADD UNIQUE INDEX `id_UNIQUE` (`id` ASC);


CREATE TABLE IF NOT EXISTS `lol`.`shiftbill` (
  `id` INT(9) NOT NULL,
  `shiftid` INT(5) NULL DEFAULT NULL,
  `billid` INT(5) NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  INDEX `sbshiftid_idx` (`shiftid` ASC),
  INDEX `sbbillsid_idx` (`billid` ASC),
  CONSTRAINT `sbshiftid`
    FOREIGN KEY (`shiftid`)
    REFERENCES `lol`.`shifts` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `sbbillsid`
    FOREIGN KEY (`billid`)
    REFERENCES `lol`.`bills` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


ALTER TABLE `lol`.`shiftbill`
CHANGE COLUMN `id` `id` INT(9) NOT NULL AUTO_INCREMENT ;

ALTER TABLE `lol`.`shiftbill`
ADD UNIQUE INDEX `sbunique` (`shiftid` ASC, `billid` ASC);


-----Ver 1.3--------
ALTER TABLE `lol`.`suppliers`
DROP FOREIGN KEY `wrkidflinf00`;

ALTER TABLE `lol`.`suppliers`
DROP COLUMN `workerid`,
DROP INDEX `wrkidfkey_idx` ;


ALTER TABLE `lol`.`billsrows`
ADD INDEX `billfkid_idx` (`billrid` ASC);

CREATE TABLE IF NOT EXISTS `lol`.`sellingproductsdetails` (
  `id` INT(5) NOT NULL,
  `quantity` INT(2) NULL DEFAULT NULL,
  `productid` INT(5) NULL DEFAULT NULL,
  `selingproductid` INT(5) NULL DEFAULT NULL,
  INDEX `selporind` (`id` ASC),
  INDEX `fkproduct_idx` (`productid` ASC),
  INDEX `fksellprodid_idx` (`selingproductid` ASC),
  CONSTRAINT `fkproduct`
    FOREIGN KEY (`productid`)
    REFERENCES `lol`.`products` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fksellprodid`
    FOREIGN KEY (`selingproductid`)
    REFERENCES `lol`.`sellingproducts` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;


DROP TABLE IF EXISTS `lol`.`supplies_status` ;

ALTER TABLE `lol`.`billsrows`
ADD CONSTRAINT `billfkid`
  FOREIGN KEY (`billrid`)
  REFERENCES `lol`.`bills` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;






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


ALTER TABLE `lol`.`transactionallog`
ADD UNIQUE INDEX `loguniq` (`monthid` ASC, `logtype` ASC);

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


CREATE TABLE IF NOT EXISTS `lol`.`transactionallog` (
  `id` INT(5) NOT NULL AUTO_INCREMENT,
  `monthid` INT(9) NULL DEFAULT NULL,
  `logtype` INT(5) NULL DEFAULT NULL,
  `comment` VARCHAR(100) NULL DEFAULT NULL,
  `tstamp` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  INDEX `logindex` (`id` ASC))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;




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