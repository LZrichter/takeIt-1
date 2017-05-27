ALTER TABLE `usuario` DROP INDEX `usuario_nome_UNIQUE`;
ALTER TABLE `usuario` ADD UNIQUE INDEX `usuario_email` (`usuario_email`);
ALTER TABLE `usuario` CHANGE COLUMN `usuario_numero` `usuario_numero` VARCHAR(50) NULL DEFAULT NULL AFTER `usuario_bairro`;

ALTER TABLE `pessoa` ALTER `pessoa_cpf` DROP DEFAULT;
ALTER TABLE `pessoa` CHANGE COLUMN `pessoa_cpf` `pessoa_cpf` VARCHAR(255) NOT NULL AFTER `pessoa_id`;

ALTER TABLE `instituicao` ALTER `instituicao_cnpj` DROP DEFAULT;
ALTER TABLE `instituicao` CHANGE COLUMN `instituicao_cnpj` `instituicao_cnpj` VARCHAR(255) NOT NULL AFTER `instituicao_id`;