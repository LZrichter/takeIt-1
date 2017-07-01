ALTER TABLE `usuario` ADD COLUMN `usuario_resumo` text NULL;

ALTER TABLE `usuario` ADD COLUMN `imagem_id` int(11) NULL DEFAULT NULL;

# Frescura
ALTER TABLE `usuario` CHANGE COLUMN `usuario_resumo` `usuario_resumo` text CHARACTER SET utf8 NULL AFTER `usuario_nivel`;
