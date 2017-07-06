DELIMITER $

CREATE TRIGGER Tgr_Notificacao_Interesse
AFTER INSERT ON interesse
FOR EACH ROW BEGIN
	INSERT INTO notificacao (notificacao_tipo, notificacao_lida, interesse_id)
	VALUES ('novo_interessado', 0, NEW.interesse_id);
END$

CREATE TRIGGER Tgr_Notificacao_Doacao
AFTER INSERT ON doacao
FOR EACH ROW BEGIN
	INSERT INTO notificacao (notificacao_tipo, notificacao_lida, interesse_id)
	VALUES ('doacao_adquirida', 0, 
	(SELECT interesse_id FROM doacao NATURAL JOIN interesse WHERE doacao_id = NEW.doacao_id LIMIT 1));
END$

CREATE TRIGGER Tgr_Notificacao_Cancelado
AFTER UPDATE ON item
FOR EACH ROW BEGIN
	IF (OLD.item_status != 'Cancelado' AND NEW.item_status = 'Cancelado') THEN
	INSERT INTO notificacao (notificacao_tipo, notificacao_lida, interesse_id)
	VALUES ('doacao_cancelada', 0, 
	(SELECT interesse_id FROM interesse i WHERE NEW.item_id = i.item_id));
	END IF;
END$

CREATE TRIGGER Tgr_Notificacao_Perdida
AFTER UPDATE ON item
FOR EACH ROW BEGIN
	IF (OLD.item_status != 'Doado' AND NEW.item_status = 'Doado') THEN
	INSERT INTO notificacao (notificacao_tipo, notificacao_lida, interesse_id)
	VALUES ('doacao_perdida', 0, 
	(SELECT interesse_id FROM interesse i WHERE NEW.item_id = i.item_id AND i.interesse_id 
	NOT IN (SELECT interesse_id FROM doacao)));
	END IF;
END$

DELIMITER ;