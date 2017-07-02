ALTER TABLE `usuario` ADD FOREIGN KEY (`imagem_id`) REFERENCES `imagem` (`imagem_id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `imagem` CHANGE `item_id` `item_id` INT(11) NULL;