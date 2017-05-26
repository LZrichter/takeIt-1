ALTER TABLE `usuario` DROP INDEX `usuario_nome_UNIQUE`;
ALTER TABLE `usuario` ADD UNIQUE INDEX `usuario_email` (`usuario_email`);