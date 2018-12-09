-- MySQL Script generated by MySQL Workbench
-- Sun Dec  9 21:42:42 2018
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema lag
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema lag
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `lag` DEFAULT CHARACTER SET utf8 ;
USE `lag` ;

-- -----------------------------------------------------
-- Table `lag`.`users`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `lag`.`users` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `login` VARCHAR(45) NOT NULL,
  `password` VARCHAR(45) NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  `firstname` VARCHAR(45) NOT NULL,
  `lastname` VARCHAR(45) NOT NULL,
  `userscol` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `lag`.`games`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `lag`.`games` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  `type` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `lag`.`avalabilities`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `lag`.`avalabilities` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `start` DATETIME NOT NULL,
  `end` DATETIME NOT NULL,
  `users_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_avalabilities_users1_idx` (`users_id` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `lag`.`sessions`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `lag`.`sessions` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `start` DATETIME NULL,
  `end` DATETIME NULL,
  `participant_id` INT NOT NULL,
  `coach_id` INT NOT NULL,
  `games_id` INT NOT NULL,
  `avalabilities_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_sessions_users_idx` (`participant_id` ASC),
  INDEX `fk_sessions_users1_idx` (`coach_id` ASC),
  INDEX `fk_sessions_games1_idx` (`games_id` ASC),
  INDEX `fk_sessions_avalabilities1_idx` (`avalabilities_id` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `lag`.`link_games_users`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `lag`.`link_games_users` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `users_id` INT NOT NULL,
  `games_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_link_games_users_users1_idx` (`users_id` ASC),
  INDEX `fk_link_games_users_games1_idx` (`games_id` ASC))
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
