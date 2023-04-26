-- MySQL Script generated by MySQL Workbench
-- Mon Apr 10 23:34:52 2023
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema Blog_PHP_P5
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema Blog_PHP_P5
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `Blog_PHP_P5` DEFAULT CHARACTER SET utf8 ;
USE `Blog_PHP_P5` ;

-- -----------------------------------------------------
-- Table `Blog_PHP_P5`.`user`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Blog_PHP_P5`.`user` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(45) NOT NULL,
  `email` VARCHAR(100) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `biography` VARCHAR(255) NULL,
  `avatar` VARCHAR(255) NOT NULL DEFAULT 'default_avatar.png',
  `authenticated` TINYINT NOT NULL DEFAULT 0,
  `role` VARCHAR(45) NOT NULL DEFAULT 'FOLLOWER',
  `registeredAt` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Blog_PHP_P5`.`post`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Blog_PHP_P5`.`post` (
  `id_post` INT NOT NULL AUTO_INCREMENT,
  `post_title` VARCHAR(45) NOT NULL,
  `post_chapo` VARCHAR(255) NOT NULL,
  `post_content` TEXT NOT NULL,
  `post_image` VARCHAR(255) NOT NULL DEFAULT 'default_post.jpg',
  `post_createdAt` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `post_updatedAt` DATETIME NULL,
  `user_id` INT NOT NULL,
  PRIMARY KEY (`id_post`, `user_id`),
  CONSTRAINT `fk_post_user`
    FOREIGN KEY (`user_id`)
    REFERENCES `Blog_PHP_P5`.`user` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `fk_post_user_idx` ON `Blog_PHP_P5`.`post` (`user_id` ASC) VISIBLE;


-- -----------------------------------------------------
-- Table `Blog_PHP_P5`.`comment`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Blog_PHP_P5`.`comment` (
  `id_comment` INT NOT NULL AUTO_INCREMENT,
  `comment_content` VARCHAR(100) NOT NULL,
  `comment_active` TINYINT NOT NULL DEFAULT 0,
  `comment_createdAt` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `comment_updatedAt` DATETIME NULL,
  `id_post` INT NOT NULL,
  `user_id` INT NOT NULL,
  PRIMARY KEY (`id_comment`, `id_post`, `user_id`),
  CONSTRAINT `fk_comment_post1`
    FOREIGN KEY (`id_post`)
    REFERENCES `Blog_PHP_P5`.`post` (`id_post`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_comment_user1`
    FOREIGN KEY (`user_id`)
    REFERENCES `Blog_PHP_P5`.`user` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `fk_comment_post1_idx` ON `Blog_PHP_P5`.`comment` (`id_post` ASC) VISIBLE;

CREATE INDEX `fk_comment_user1_idx` ON `Blog_PHP_P5`.`comment` (`user_id` ASC) VISIBLE;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;