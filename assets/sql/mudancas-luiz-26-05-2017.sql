ALTER TABLE `usuario` DROP INDEX `usuario_nome_UNIQUE`;
ALTER TABLE `usuario` ADD UNIQUE INDEX `usuario_email` (`usuario_email`);
ALTER TABLE `usuario` CHANGE COLUMN `usuario_numero` `usuario_numero` VARCHAR(50) NULL DEFAULT NULL AFTER `usuario_bairro`;