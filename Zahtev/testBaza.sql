-- MySQL Script generated by MySQL Workbench
-- 04/02/17 01:01:38
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema lol
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema lol
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `lol` DEFAULT CHARACTER SET utf8 ;
USE `lol` ;

-- -----------------------------------------------------
-- Table `lol`.`ranks`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `lol`.`ranks` ;

CREATE TABLE IF NOT EXISTS `lol`.`ranks` (
  `id` INT(5) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `unrank` (`name` ASC));


-- -----------------------------------------------------
-- Table `lol`.`positions`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `lol`.`positions` ;

CREATE TABLE IF NOT EXISTS `lol`.`positions` (
  `id` INT(5) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `unposition` (`name` ASC));


-- -----------------------------------------------------
-- Table `lol`.`users`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `lol`.`users` ;

CREATE TABLE IF NOT EXISTS `lol`.`users` (
  `id` INT(9) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(50) NULL,
  `lastname` VARCHAR(50) NULL,
  `arenausername` VARCHAR(50) NOT NULL,
  `summonername` VARCHAR(50) NULL,
  `rankid` INT(5) NOT NULL,
  `positionid` INT(5) NULL,
  `phone` VARCHAR(45) NULL,
  `discount` INT(3) NULL,
  `create_time` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `creditstatus` INT(1) NULL,
  PRIMARY KEY (`id`),
  INDEX `rankid_idx` (`rankid` ASC),
  INDEX `positionid_idx` (`positionid` ASC),
  UNIQUE INDEX `unuser` (`arenausername` ASC),
  CONSTRAINT `rankid`
    FOREIGN KEY (`rankid`)
    REFERENCES `lol`.`ranks` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `positionid`
    FOREIGN KEY (`positionid`)
    REFERENCES `lol`.`positions` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);


-- -----------------------------------------------------
-- Table `lol`.`heroes`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `lol`.`heroes` ;

CREATE TABLE IF NOT EXISTS `lol`.`heroes` (
  `id` INT(5) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `unheroe` (`name` ASC));


-- -----------------------------------------------------
-- Table `lol`.`workertype`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `lol`.`workertype` ;

CREATE TABLE IF NOT EXISTS `lol`.`workertype` (
  `id` INT(5) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `uwktype` (`name` ASC));


-- -----------------------------------------------------
-- Table `lol`.`workers`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `lol`.`workers` ;

CREATE TABLE IF NOT EXISTS `lol`.`workers` (
  `id` INT(5) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(50) NOT NULL,
  `lastname` VARCHAR(50) NULL,
  `email` VARCHAR(100) NULL,
  `password` VARCHAR(50) NULL,
  `workertypeid` INT(5) NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `unworker` (`email` ASC),
  INDEX `fkwrktype_idx` (`workertypeid` ASC),
  CONSTRAINT `fkwrktype`
    FOREIGN KEY (`workertypeid`)
    REFERENCES `lol`.`workertype` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);


-- -----------------------------------------------------
-- Table `lol`.`userheroresult`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `lol`.`userheroresult` ;

CREATE TABLE IF NOT EXISTS `lol`.`userheroresult` (
  `id` INT(5) NOT NULL AUTO_INCREMENT,
  `userid` INT(9) NOT NULL,
  `heroid` INT(5) NULL,
  `matchdate` DATE NULL,
  `matchtime` TIME NULL,
  `workerid` INT(5) NULL,
  `timestamp` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  INDEX `useridfk_idx` (`userid` ASC),
  INDEX `heroidfk_idx` (`heroid` ASC),
  INDEX `wrkidfl_idx` (`workerid` ASC),
  UNIQUE INDEX `usrherodate` (`userid` ASC, `heroid` ASC, `matchtime` ASC, `matchdate` ASC),
  CONSTRAINT `heroidfk`
    FOREIGN KEY (`heroid`)
    REFERENCES `lol`.`heroes` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `useridfk`
    FOREIGN KEY (`userid`)
    REFERENCES `lol`.`users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `wrkidfl`
    FOREIGN KEY (`workerid`)
    REFERENCES `lol`.`workers` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);


-- -----------------------------------------------------
-- Table `lol`.`credit`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `lol`.`credit` ;

CREATE TABLE IF NOT EXISTS `lol`.`credit` (
  `id` INT(5) NOT NULL AUTO_INCREMENT,
  `userid` INT(9) NULL,
  `value` INT(4) NULL,
  `workerid` INT(5) NULL,
  `timestamp` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `expired` INT(2) NULL,
  PRIMARY KEY (`id`),
  INDEX `fkuserid_idx` (`userid` ASC),
  INDEX `fkwrkid_idx` (`workerid` ASC),
  CONSTRAINT `fkuserid`
    FOREIGN KEY (`userid`)
    REFERENCES `lol`.`users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fkwrkid`
    FOREIGN KEY (`workerid`)
    REFERENCES `lol`.`workers` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);


-- -----------------------------------------------------
-- Table `lol`.`reservations`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `lol`.`reservations` ;

CREATE TABLE IF NOT EXISTS `lol`.`reservations` (
  `id` INT(5) NOT NULL AUTO_INCREMENT,
  `timedate` DATETIME NOT NULL,
  `timestamp` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `computers` VARCHAR(100) NOT NULL,
  `userid` INT(9) NULL,
  `workerid` INT(5) NULL,
  `confirmed` INT(2) NULL,
  `confirmworkerid` INT(5) NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `uniqres` (`timedate` ASC, `computers` ASC, `userid` ASC),
  INDEX `fkresusrid_idx` (`userid` ASC),
  INDEX `fkreswrkid_idx` (`workerid` ASC),
  CONSTRAINT `fkresusrid`
    FOREIGN KEY (`userid`)
    REFERENCES `lol`.`users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fkreswrkid`
    FOREIGN KEY (`workerid`)
    REFERENCES `lol`.`workers` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
COMMENT = '					';


-- -----------------------------------------------------
-- Table `lol`.`informations`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `lol`.`informations` ;

CREATE TABLE IF NOT EXISTS `lol`.`informations` (
  `id` INT(5) NOT NULL AUTO_INCREMENT,
  `date` DATE NULL,
  `tittle` VARCHAR(45) NULL,
  `text` TEXT(1000) NULL,
  `workerid` INT(5) NULL,
  `timestamp` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  INDEX `wrkidfl_idx` (`workerid` ASC),
  CONSTRAINT `wrkidflinf`
    FOREIGN KEY (`workerid`)
    REFERENCES `lol`.`workers` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);


-- -----------------------------------------------------
-- Table `lol`.`suppliers`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `lol`.`suppliers` ;

CREATE TABLE IF NOT EXISTS `lol`.`suppliers` (
  `id` INT(5) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) NOT NULL,
  `workerid` INT(5) NULL,
  `timestamp` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  INDEX `wrkidfkey_idx` (`workerid` ASC),
  CONSTRAINT `wrkidflinf00`
    FOREIGN KEY (`workerid`)
    REFERENCES `lol`.`workers` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);


-- -----------------------------------------------------
-- Table `lol`.`orders`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `lol`.`orders` ;

CREATE TABLE IF NOT EXISTS `lol`.`orders` (
  `id` INT(5) NOT NULL AUTO_INCREMENT,
  `date` DATE NULL,
  `workerid` INT(5) NULL,
  `timestamp` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `supplierid` INT(5) NULL,
  PRIMARY KEY (`id`),
  INDEX `wrkidfl_idx` (`workerid` ASC),
  INDEX `fkruplierid_idx` (`supplierid` ASC),
  CONSTRAINT `wrkidflinf0`
    FOREIGN KEY (`workerid`)
    REFERENCES `lol`.`workers` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fksuplierid`
    FOREIGN KEY (`supplierid`)
    REFERENCES `lol`.`suppliers` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);


-- -----------------------------------------------------
-- Table `lol`.`producttype`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `lol`.`producttype` ;

CREATE TABLE IF NOT EXISTS `lol`.`producttype` (
  `id` INT(5) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(50) NULL,
  `create_time` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  INDEX `porind` (`id` ASC));


-- -----------------------------------------------------
-- Table `lol`.`products`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `lol`.`products` ;

CREATE TABLE IF NOT EXISTS `lol`.`products` (
  `id` INT(5) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(50) NOT NULL,
  `typeid` INT(5) NOT NULL,
  `create_time` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  INDEX `porind` (`id` ASC),
  INDEX `fkprodtype_idx` (`typeid` ASC),
  CONSTRAINT `fkprodtype`
    FOREIGN KEY (`typeid`)
    REFERENCES `lol`.`producttype` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);


-- -----------------------------------------------------
-- Table `lol`.`supplies`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `lol`.`supplies` ;

CREATE TABLE IF NOT EXISTS `lol`.`supplies` (
  `id` INT(5) NOT NULL,
  `status` INT(2) NULL COMMENT 'status: 1 - na stanju; 2-prodato.',
  `amount` INT(5) NULL,
  `orderid` INT(5) NULL,
  `productid` INT(5) NULL,
  `price` FLOAT(10,2) NULL,
  `create_time` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  INDEX `suppind` (`id` ASC),
  UNIQUE INDEX `uniqusupplie` (`orderid` ASC, `productid` ASC),
  INDEX `fkprodid_idx` (`productid` ASC),
  CONSTRAINT `fkprodid`
    FOREIGN KEY (`productid`)
    REFERENCES `lol`.`products` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fkorderid`
    FOREIGN KEY (`orderid`)
    REFERENCES `lol`.`orders` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
