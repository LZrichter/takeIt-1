CREATE TABLE `notificacao` (
	`notificacao_id` INT(11) NOT NULL AUTO_INCREMENT,
	`notificacao_tipo` ENUM('doacao_adquirida','doacao_perdida','doacao_cancelada','nova_mensagem','novo_interessado') NOT NULL,
	`notificacao_lida` TINYINT(4) NOT NULL,
	`interesse_id` INT(11) NOT NULL,
	PRIMARY KEY (`notificacao_id`),
	INDEX `FK_notificacao_interesse` (`interesse_id`),
	CONSTRAINT `FK_notificacao_interesse` FOREIGN KEY (`interesse_id`) REFERENCES `interesse` (`interesse_id`) ON UPDATE NO ACTION ON DELETE NO ACTION
) COLLATE='utf8_general_ci' ENGINE=InnoDB;
