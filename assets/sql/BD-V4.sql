-- --------------------------------------------------------
-- Servidor:                     127.0.0.1
-- Versão do servidor:           5.7.14 - MySQL Community Server (GPL)
-- OS do Servidor:               Win64
-- HeidiSQL Versão:              9.4.0.5125
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Copiando estrutura do banco de dados para takeit
DROP DATABASE IF EXISTS `takeit`;
CREATE DATABASE IF NOT EXISTS `takeit` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `takeit`;

-- Copiando estrutura para tabela takeit.categoria
DROP TABLE IF EXISTS `categoria`;
CREATE TABLE IF NOT EXISTS `categoria` (
  `categoria_id` int(11) NOT NULL AUTO_INCREMENT,
  `categoria_nome` varchar(255) NOT NULL,
  PRIMARY KEY (`categoria_id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;

-- Exportação de dados foi desmarcado.
-- Copiando estrutura para tabela takeit.chat
DROP TABLE IF EXISTS `chat`;
CREATE TABLE IF NOT EXISTS `chat` (
  `chat_id` int(11) NOT NULL AUTO_INCREMENT,
  `chat_text` varchar(255) DEFAULT NULL,
  `chat_data` datetime DEFAULT NULL,
  `interesse_id` int(11) NOT NULL,
  `chat_quem` enum('Doador','Beneficiário') DEFAULT NULL,
  PRIMARY KEY (`chat_id`),
  KEY `fk_chat_interesse1_idx` (`interesse_id`),
  CONSTRAINT `fk_chat_interesse1` FOREIGN KEY (`interesse_id`) REFERENCES `interesse` (`interesse_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;

-- Exportação de dados foi desmarcado.
-- Copiando estrutura para tabela takeit.cidade
DROP TABLE IF EXISTS `cidade`;
CREATE TABLE IF NOT EXISTS `cidade` (
  `cidade_id` int(11) NOT NULL AUTO_INCREMENT,
  `cidade_nome` varchar(255) NOT NULL,
  `estado_id` int(11) NOT NULL,
  PRIMARY KEY (`cidade_id`),
  KEY `fk_cidade_estado1_idx` (`estado_id`),
  CONSTRAINT `fk_cidade_estado1` FOREIGN KEY (`estado_id`) REFERENCES `estado` (`estado_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=5565 DEFAULT CHARSET=utf8;

-- Exportação de dados foi desmarcado.
-- Copiando estrutura para tabela takeit.denuncia
DROP TABLE IF EXISTS `denuncia`;
CREATE TABLE IF NOT EXISTS `denuncia` (
  `denuncia_id` int(11) NOT NULL AUTO_INCREMENT,
  `denuncia_text` varchar(255) NOT NULL,
  `denuncia_data` date NOT NULL,
  `denuncia_status` enum('Aberta','Ignorada','Resolvida') DEFAULT NULL,
  `usuario_xnove` int(11) NOT NULL,
  `usuario_vacilao` int(11) DEFAULT NULL,
  `item_vacilao` int(11) DEFAULT NULL,
  PRIMARY KEY (`denuncia_id`),
  KEY `fk_denuncia_item1_idx` (`item_vacilao`),
  KEY `fk_denuncia_usuario1_idx` (`usuario_xnove`),
  KEY `fk_denuncia_usuario2_idx` (`usuario_vacilao`),
  CONSTRAINT `fk_denuncia_item1` FOREIGN KEY (`item_vacilao`) REFERENCES `item` (`item_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_denuncia_usuario1` FOREIGN KEY (`usuario_xnove`) REFERENCES `usuario` (`usuario_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_denuncia_usuario2` FOREIGN KEY (`usuario_vacilao`) REFERENCES `usuario` (`usuario_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Exportação de dados foi desmarcado.
-- Copiando estrutura para tabela takeit.doacao
DROP TABLE IF EXISTS `doacao`;
CREATE TABLE IF NOT EXISTS `doacao` (
  `doacao_id` int(11) NOT NULL AUTO_INCREMENT,
  `doacao_qtde` int(11) DEFAULT NULL,
  `doacao_data` date DEFAULT NULL,
  `interesse_id` int(11) NOT NULL,
  `doacao_agradecimento` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`doacao_id`),
  KEY `fk_doacao_interesse1_idx` (`interesse_id`),
  CONSTRAINT `fk_doacao_interesse1` FOREIGN KEY (`interesse_id`) REFERENCES `interesse` (`interesse_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Exportação de dados foi desmarcado.
-- Copiando estrutura para tabela takeit.estado
DROP TABLE IF EXISTS `estado`;
CREATE TABLE IF NOT EXISTS `estado` (
  `estado_id` int(11) NOT NULL AUTO_INCREMENT,
  `estado_uf` varchar(255) NOT NULL,
  PRIMARY KEY (`estado_id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8;

-- Exportação de dados foi desmarcado.
-- Copiando estrutura para tabela takeit.imagem
DROP TABLE IF EXISTS `imagem`;
CREATE TABLE IF NOT EXISTS `imagem` (
  `imagem_id` int(11) NOT NULL AUTO_INCREMENT,
  `imagem_nome` varchar(255) NOT NULL,
  `imagem_caminho` text NOT NULL,
  `imagem_tamanho` int(11) DEFAULT NULL,
  `item_id` int(11) NOT NULL,
  PRIMARY KEY (`imagem_id`),
  UNIQUE KEY `imagem_nome_UNIQUE` (`imagem_nome`),
  KEY `fk_imagem_item1_idx` (`item_id`),
  CONSTRAINT `fk_imagem_item1` FOREIGN KEY (`item_id`) REFERENCES `item` (`item_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- Exportação de dados foi desmarcado.
-- Copiando estrutura para tabela takeit.instituicao
DROP TABLE IF EXISTS `instituicao`;
CREATE TABLE IF NOT EXISTS `instituicao` (
  `instituicao_id` int(11) NOT NULL,
  `instituicao_cnpj` varchar(255) NOT NULL,
  `instituicao_site` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`instituicao_id`),
  CONSTRAINT `fk_instituicao_usuario1` FOREIGN KEY (`instituicao_id`) REFERENCES `usuario` (`usuario_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Exportação de dados foi desmarcado.
-- Copiando estrutura para tabela takeit.instituicao_categoria
DROP TABLE IF EXISTS `instituicao_categoria`;
CREATE TABLE IF NOT EXISTS `instituicao_categoria` (
  `instituicao_id` int(11) NOT NULL,
  `categoria_id` int(11) NOT NULL,
  PRIMARY KEY (`instituicao_id`,`categoria_id`),
  KEY `fk_instituicao_has_categoria_categoria1_idx` (`categoria_id`),
  KEY `fk_instituicao_has_categoria_instituicao1_idx` (`instituicao_id`),
  CONSTRAINT `fk_instituicao_has_categoria_categoria1` FOREIGN KEY (`categoria_id`) REFERENCES `categoria` (`categoria_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_instituicao_has_categoria_instituicao1` FOREIGN KEY (`instituicao_id`) REFERENCES `instituicao` (`instituicao_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Exportação de dados foi desmarcado.
-- Copiando estrutura para tabela takeit.interesse
DROP TABLE IF EXISTS `interesse`;
CREATE TABLE IF NOT EXISTS `interesse` (
  `interesse_id` int(11) NOT NULL AUTO_INCREMENT,
  `interesse_data` datetime NOT NULL,
  `item_id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `chat_lst_msg_doador` int(11) DEFAULT NULL,
  `chat_lst_msg_beneficiario` int(11) DEFAULT NULL,
  PRIMARY KEY (`interesse_id`),
  KEY `fk_interesse_item1_idx` (`item_id`),
  KEY `fk_interesse_usuario1_idx` (`usuario_id`),
  KEY `fk_interesse_msg_doador` (`chat_lst_msg_doador`),
  KEY `fk_interesse_msg_beneficiario` (`chat_lst_msg_beneficiario`),
  CONSTRAINT `fk_interesse_item1` FOREIGN KEY (`item_id`) REFERENCES `item` (`item_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_interesse_msg_beneficiario` FOREIGN KEY (`chat_lst_msg_beneficiario`) REFERENCES `chat` (`chat_id`) ON DELETE SET NULL ON UPDATE SET NULL,
  CONSTRAINT `fk_interesse_msg_doador` FOREIGN KEY (`chat_lst_msg_doador`) REFERENCES `chat` (`chat_id`) ON DELETE SET NULL ON UPDATE SET NULL,
  CONSTRAINT `fk_interesse_usuario1` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`usuario_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- Exportação de dados foi desmarcado.
-- Copiando estrutura para tabela takeit.item
DROP TABLE IF EXISTS `item`;
CREATE TABLE IF NOT EXISTS `item` (
  `item_id` int(11) NOT NULL AUTO_INCREMENT,
  `item_descricao` text NOT NULL,
  `item_qtde` int(11) NOT NULL,
  `item_detalhes` text NOT NULL,
  `item_data` date DEFAULT NULL,
  `item_status` enum('Disponível','Solicitado','Cancelado','Doado') DEFAULT NULL,
  `usuario_id` int(11) NOT NULL,
  `categoria_id` int(11) NOT NULL,
  PRIMARY KEY (`item_id`),
  KEY `fk_item_categoria1_idx` (`categoria_id`),
  KEY `fk_item_usuario1_idx` (`usuario_id`),
  CONSTRAINT `fk_item_categoria1` FOREIGN KEY (`categoria_id`) REFERENCES `categoria` (`categoria_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_item_usuario1` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`usuario_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- Exportação de dados foi desmarcado.
-- Copiando estrutura para tabela takeit.pessoa
DROP TABLE IF EXISTS `pessoa`;
CREATE TABLE IF NOT EXISTS `pessoa` (
  `pessoa_id` int(11) NOT NULL,
  `pessoa_cpf` varchar(255) NOT NULL,
  PRIMARY KEY (`pessoa_id`),
  UNIQUE KEY `pessoa_cpf_UNIQUE` (`pessoa_cpf`),
  CONSTRAINT `fk_pessoa_usuario1` FOREIGN KEY (`pessoa_id`) REFERENCES `usuario` (`usuario_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Exportação de dados foi desmarcado.
-- Copiando estrutura para tabela takeit.usuario
DROP TABLE IF EXISTS `usuario`;
CREATE TABLE IF NOT EXISTS `usuario` (
  `usuario_id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario_nome` varchar(255) NOT NULL,
  `usuario_email` varchar(255) NOT NULL,
  `usuario_senha` varchar(255) NOT NULL,
  `usuario_endereco` varchar(255) DEFAULT NULL,
  `usuario_bairro` varchar(255) DEFAULT NULL,
  `usuario_numero` varchar(50) DEFAULT NULL,
  `usuario_complemento` varchar(255) DEFAULT NULL,
  `usuario_telefone` varchar(255) DEFAULT NULL,
  `usuario_ativo` tinyint(1) DEFAULT NULL,
  `usuario_nivel` enum('Admin','Pessoa','Instituição') NOT NULL DEFAULT 'Pessoa',
  `usuario_resumo` text,
  `cidade_id` int(11) NOT NULL,
  `imagem_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`usuario_id`),
  UNIQUE KEY `usuario_email` (`usuario_email`),
  KEY `fk_usuario_cidade1_idx` (`cidade_id`),
  CONSTRAINT `fk_usuario_cidade1` FOREIGN KEY (`cidade_id`) REFERENCES `cidade` (`cidade_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;

-- Exportação de dados foi desmarcado.
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
