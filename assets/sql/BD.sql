-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema takeit
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema takeit
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `takeit` DEFAULT CHARACTER SET utf8 ;
USE `takeit` ;

-- -----------------------------------------------------
-- Table `takeit`.`categoria`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `takeit`.`categoria` ;

CREATE TABLE IF NOT EXISTS `takeit`.`categoria` (
  `categoria_id` INT(11) NOT NULL AUTO_INCREMENT,
  `categoria_nome` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`categoria_id`))
ENGINE = InnoDB
AUTO_INCREMENT = 25
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `takeit`.`estado`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `takeit`.`estado` ;

CREATE TABLE IF NOT EXISTS `takeit`.`estado` (
  `estado_id` INT(11) NOT NULL AUTO_INCREMENT,
  `estado_uf` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`estado_id`))
ENGINE = InnoDB
AUTO_INCREMENT = 28
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `takeit`.`cidade`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `takeit`.`cidade` ;

CREATE TABLE IF NOT EXISTS `takeit`.`cidade` (
  `cidade_id` INT(11) NOT NULL AUTO_INCREMENT,
  `cidade_nome` VARCHAR(255) NOT NULL,
  `estado_id` INT(11) NOT NULL,
  PRIMARY KEY (`cidade_id`),
  INDEX `fk_cidade_estado1_idx` (`estado_id` ASC),
  CONSTRAINT `fk_cidade_estado1`
    FOREIGN KEY (`estado_id`)
    REFERENCES `takeit`.`estado` (`estado_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 5565
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `takeit`.`usuario`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `takeit`.`usuario` ;

CREATE TABLE IF NOT EXISTS `takeit`.`usuario` (
  `usuario_id` INT(11) NOT NULL AUTO_INCREMENT,
  `usuario_nome` VARCHAR(255) NOT NULL,
  `usuario_email` VARCHAR(255) NOT NULL,
  `usuario_senha` VARCHAR(255) NOT NULL,
  `usuario_endereco` VARCHAR(255) NULL DEFAULT NULL,
  `usuario_bairro` VARCHAR(255) NULL DEFAULT NULL,
  `usuario_numero` INT(11) NULL DEFAULT NULL,
  `usuario_complemento` VARCHAR(255) NULL DEFAULT NULL,
  `usuario_telefone` VARCHAR(255) NULL DEFAULT NULL,
  `usuario_ativo` TINYINT(1) NULL DEFAULT NULL,
  `usuario_nivel` ENUM('Admin', 'Pessoa', 'Instituição') NOT NULL DEFAULT 'Pessoa',
  `cidade_id` INT(11) NOT NULL,
  PRIMARY KEY (`usuario_id`),
  UNIQUE INDEX `usuario_nome_UNIQUE` (`usuario_nome` ASC),
  INDEX `fk_usuario_cidade1_idx` (`cidade_id` ASC),
  CONSTRAINT `fk_usuario_cidade1`
    FOREIGN KEY (`cidade_id`)
    REFERENCES `takeit`.`cidade` (`cidade_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 2
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `takeit`.`item`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `takeit`.`item` ;

CREATE TABLE IF NOT EXISTS `takeit`.`item` (
  `item_id` INT(11) NOT NULL AUTO_INCREMENT,
  `item_descricao` TEXT NULL DEFAULT NULL,
  `item_qtde` INT(11) NULL DEFAULT NULL,
  `item_data` DATE NULL DEFAULT NULL,
  `item_status` ENUM('Disponível', 'Solicitado', 'Cancelado', 'Doado') NULL DEFAULT NULL,
  `usuario_id` INT(11) NOT NULL,
  `categoria_id` INT(11) NOT NULL,
  PRIMARY KEY (`item_id`),
  INDEX `fk_item_categoria1_idx` (`categoria_id` ASC),
  INDEX `fk_item_usuario1_idx` (`usuario_id` ASC),
  CONSTRAINT `fk_item_categoria1`
    FOREIGN KEY (`categoria_id`)
    REFERENCES `takeit`.`categoria` (`categoria_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_item_usuario1`
    FOREIGN KEY (`usuario_id`)
    REFERENCES `takeit`.`usuario` (`usuario_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `takeit`.`interesse`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `takeit`.`interesse` ;

CREATE TABLE IF NOT EXISTS `takeit`.`interesse` (
  `interesse_id` INT(11) NOT NULL AUTO_INCREMENT,
  `interesse_data` DATETIME NOT NULL,
  `item_id` INT(11) NOT NULL,
  `usuario_id` INT(11) NOT NULL,
  PRIMARY KEY (`interesse_id`),
  INDEX `fk_interesse_item1_idx` (`item_id` ASC),
  INDEX `fk_interesse_usuario1_idx` (`usuario_id` ASC),
  CONSTRAINT `fk_interesse_item1`
    FOREIGN KEY (`item_id`)
    REFERENCES `takeit`.`item` (`item_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_interesse_usuario1`
    FOREIGN KEY (`usuario_id`)
    REFERENCES `takeit`.`usuario` (`usuario_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `takeit`.`chat`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `takeit`.`chat` ;

CREATE TABLE IF NOT EXISTS `takeit`.`chat` (
  `chat_id` INT(11) NOT NULL AUTO_INCREMENT,
  `chat_text` VARCHAR(255) NULL DEFAULT NULL,
  `chat_data` DATETIME NULL DEFAULT NULL,
  `interesse_id` INT(11) NOT NULL,
  `chat_quem` ENUM('Doador', 'Beneficiário') NULL DEFAULT NULL,
  PRIMARY KEY (`chat_id`),
  INDEX `fk_chat_interesse1_idx` (`interesse_id` ASC),
  CONSTRAINT `fk_chat_interesse1`
    FOREIGN KEY (`interesse_id`)
    REFERENCES `takeit`.`interesse` (`interesse_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `takeit`.`denuncia`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `takeit`.`denuncia` ;

CREATE TABLE IF NOT EXISTS `takeit`.`denuncia` (
  `denuncia_id` INT(11) NOT NULL AUTO_INCREMENT,
  `denuncia_text` VARCHAR(255) NOT NULL,
  `denuncia_data` DATE NOT NULL,
  `denuncia_status` ENUM('Aberta', 'Ignorada', 'Resolvida') NULL DEFAULT NULL,
  `usuario_xnove` INT(11) NOT NULL,
  `usuario_vacilao` INT(11) NULL DEFAULT NULL,
  `item_vacilao` INT(11) NULL DEFAULT NULL,
  PRIMARY KEY (`denuncia_id`),
  INDEX `fk_denuncia_item1_idx` (`item_vacilao` ASC),
  INDEX `fk_denuncia_usuario1_idx` (`usuario_xnove` ASC),
  INDEX `fk_denuncia_usuario2_idx` (`usuario_vacilao` ASC),
  CONSTRAINT `fk_denuncia_item1`
    FOREIGN KEY (`item_vacilao`)
    REFERENCES `takeit`.`item` (`item_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_denuncia_usuario1`
    FOREIGN KEY (`usuario_xnove`)
    REFERENCES `takeit`.`usuario` (`usuario_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_denuncia_usuario2`
    FOREIGN KEY (`usuario_vacilao`)
    REFERENCES `takeit`.`usuario` (`usuario_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `takeit`.`doacao`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `takeit`.`doacao` ;

CREATE TABLE IF NOT EXISTS `takeit`.`doacao` (
  `doacao_id` INT(11) NOT NULL AUTO_INCREMENT,
  `doacao_qtde` INT(11) NULL DEFAULT NULL,
  `doacao_data` DATE NULL DEFAULT NULL,
  `interesse_id` INT(11) NOT NULL,
  `doacao_agradecimento` VARCHAR(45) NULL DEFAULT NULL,
  PRIMARY KEY (`doacao_id`),
  INDEX `fk_doacao_interesse1_idx` (`interesse_id` ASC),
  CONSTRAINT `fk_doacao_interesse1`
    FOREIGN KEY (`interesse_id`)
    REFERENCES `takeit`.`interesse` (`interesse_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `takeit`.`imagem`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `takeit`.`imagem` ;

CREATE TABLE IF NOT EXISTS `takeit`.`imagem` (
  `imagem_id` INT(11) NOT NULL AUTO_INCREMENT,
  `imagem_nome` VARCHAR(255) NOT NULL,
  `imagem_caminho` VARCHAR(255) NOT NULL,
  `imagem_tamanho` INT(11) NULL DEFAULT NULL,
  `item_id` INT(11) NOT NULL,
  PRIMARY KEY (`imagem_id`),
  UNIQUE INDEX `imagem_nome_UNIQUE` (`imagem_nome` ASC),
  INDEX `fk_imagem_item1_idx` (`item_id` ASC),
  CONSTRAINT `fk_imagem_item1`
    FOREIGN KEY (`item_id`)
    REFERENCES `takeit`.`item` (`item_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `takeit`.`instituicao`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `takeit`.`instituicao` ;

CREATE TABLE IF NOT EXISTS `takeit`.`instituicao` (
  `instituicao_id` INT(11) NOT NULL,
  `instituicao_cnpj` INT(11) NOT NULL,
  `instituicao_site` VARCHAR(255) NULL DEFAULT NULL,
  PRIMARY KEY (`instituicao_id`),
  CONSTRAINT `fk_instituicao_usuario1`
    FOREIGN KEY (`instituicao_id`)
    REFERENCES `takeit`.`usuario` (`usuario_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `takeit`.`instituicao_categoria`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `takeit`.`instituicao_categoria` ;

CREATE TABLE IF NOT EXISTS `takeit`.`instituicao_categoria` (
  `instituicao_id` INT(11) NOT NULL,
  `categoria_id` INT(11) NOT NULL,
  PRIMARY KEY (`instituicao_id`, `categoria_id`),
  INDEX `fk_instituicao_has_categoria_categoria1_idx` (`categoria_id` ASC),
  INDEX `fk_instituicao_has_categoria_instituicao1_idx` (`instituicao_id` ASC),
  CONSTRAINT `fk_instituicao_has_categoria_categoria1`
    FOREIGN KEY (`categoria_id`)
    REFERENCES `takeit`.`categoria` (`categoria_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_instituicao_has_categoria_instituicao1`
    FOREIGN KEY (`instituicao_id`)
    REFERENCES `takeit`.`instituicao` (`instituicao_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `takeit`.`pessoa`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `takeit`.`pessoa` ;

CREATE TABLE IF NOT EXISTS `takeit`.`pessoa` (
  `pessoa_id` INT(11) NOT NULL,
  `pessoa_cpf` INT(11) NOT NULL,
  PRIMARY KEY (`pessoa_id`),
  UNIQUE INDEX `pessoa_cpf_UNIQUE` (`pessoa_cpf` ASC),
  CONSTRAINT `fk_pessoa_usuario1`
    FOREIGN KEY (`pessoa_id`)
    REFERENCES `takeit`.`usuario` (`usuario_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
