-- Colocando as chaves relacionadas ao usuário na pessoa como cascate, pra não da problema
ALTER TABLE `pessoa` DROP FOREIGN KEY `fk_pessoa_usuario1`;
ALTER TABLE `pessoa` ADD CONSTRAINT `fk_pessoa_usuario1` FOREIGN KEY (`pessoa_id`) REFERENCES `usuario` (`usuario_id`) ON UPDATE CASCADE ON DELETE CASCADE;

-- Colocando as chaves relacionadas ao usuário na instituição como cascate, pra não da problema
ALTER TABLE `instituicao` DROP FOREIGN KEY `fk_instituicao_usuario1`;
ALTER TABLE `instituicao` ADD CONSTRAINT `fk_instituicao_usuario1` FOREIGN KEY (`instituicao_id`) REFERENCES `usuario` (`usuario_id`) ON UPDATE CASCADE ON DELETE CASCADE;