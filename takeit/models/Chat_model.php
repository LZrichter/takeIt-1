<?php defined('BASEPATH') OR exit('OPSSS... Não é permitido direto acesso ao script!!');

class Chat_model extends CI_Model{

	function __construct(){
		parent::__construct();

		if(isset($this->input->post()["tipo_pessoa"]))
			$this->tipoPessoa = $this->input->post()["tipo_pessoa"];
	}

	/**
	 * Devolve uma quantidade de mensagens de um bate-papo, retornando 50 cada vez
	 * @param  int 		$idInteresse ID do interesse a ser buscado a conversa
	 * @param  int      $porcao      Qual porção do chat deve ser retornada, contando sempre em multiplos de 20. Padrão 1
	 *                               Ex: Se a porção for 1, será retornado as ultimas 20 mensagens
	 *                                   Se for 2, será retornando apartir da 21 mensagem mais antiga pra frente
	 * @param  int|null $idFlagChat  Caso queira buscar 50 mensagens a partir de certa mensagem, 
	 *                               deve ser colocado o ID da mensagem como flag
	 * @return array                 Todas as mensagens referentes aos filtros
	 */
	public function porcaoChatLimite(int $idInteresse, int $porcao = 1, int $limite = 20, int $idFlagChat = null){
		if(!isset($idInteresse) || empty(trim($idInteresse)))
			return array("tipo" => "erro", "msg" => "Informação insuficiente para executar a consulta.");

		try{
			if(isset($idFlagChat) && !is_null($idFlagChat) && !empty(trim($idFlagChat)))
				$where_flag_chat = "AND chat_id < $idFlagChat";
			else $where_flag_chat = "";

			$limite_inicial = ($porcao - 1) * $limite;
			$limite_final =   ($porcao * $limite) - 1;

			$sql = "
				SELECT * 
				FROM (
					SELECT 
						*,
						DATE_FORMAT(chat_data, '%d/%m %h:%i') as chat_data_formatada
					FROM chat
					WHERE interesse_id = $idInteresse $where_flag_chat
					ORDER BY chat_id DESC
					LIMIT $limite_inicial, $limite_final
				) x
				ORDER BY x.chat_id ASC
			";

			if(!$query = $this->db->query($sql))
				return ["tipo" => "erro", "msg" => "Não foi possivel buscar as mensagens."];
			else{
				if(!count($query->result())) 
					return ["tipo" => "info", "msg" => "zero"];

				$this->atualizaVisualizacaoMsg($idInteresse);

				$i = 0;
				while($i<count($query->result())){
					foreach($query->result()[$i] as $campo => $valor)
						$dados[$i][$campo] = $valor;

					$i++;
				}

				return $dados;
			}
		}catch(PDOException $PDOE){
			return ["tipo" => "erro", "msg" => "Problema ao processar os dados no sistema. - Código: " . $PDOE->getCode()];
		}catch(Exception $NE){
			return ["tipo" => "erro", "msg" => "Problema ao executar a tarefa no sistema. - Código: " . $NE->getCode()];
		}

		return ["tipo" => "erro", "msg" => "Problema inesperado no sistema. Tente novamente mais tarde!"];
	}

	/**
	 * Salva uma mensagem enviada para o chat
	 * @param  string $msg         Mensagem a ser salva
	 * @param  int    $idInteresse Interesse que a mensagem está ligada
	 * @param  strng  $tipoPessoa  Quem esta mandando a mensagem
	 * @return array               Array que retorna um ok ou retorna uma mensagem de erro
	 */
	public function salvaMensagem($msg, int $idInteresse, $tipoPessoa){
		if(!isset($msg) || empty(trim($msg)) || !isset($idInteresse) || !isset($tipoPessoa))
			return ["tipo" => "erro", "msg" => "Sem informações suficientes para mandar a mensagem, tente novamente mais tarde."];

		try{
			$data = date('Y-m-d H:i:s');
			
			$sql = "
				INSERT INTO chat (chat_text, chat_data, interesse_id, chat_quem) 
				VALUES (
					".$this->db->escape($msg).",
					'".$data."',
					".$this->db->escape($idInteresse).",
					".$this->db->escape($tipoPessoa)."
				)
			";

			if(!$query = $this->db->query($sql))
				return ["tipo" => "erro", "msg" => "Não foi possivel mandar a mensagem, tente novamente mais tarde."];
			else{
				$chat = [
					"id" => $this->db->insert_id(),
					"msg" => $msg,
					"data" => date_format(date_create($data), " m/d H:i")
				];

				return ["tipo" => "sucesso", "msg" => $chat];
			}
		}catch(PDOException $PDOE){
			return ["tipo" => "erro", "msg" => "Problema ao processar os dados no sistema. - Código: " . $PDOE->getCode()];
		}catch(Exception $NE){
			return ["tipo" => "erro", "msg" => "Problema ao executar a tarefa no sistema. - Código: " . $NE->getCode()];
		}

		return ["tipo" => "erro", "msg" => "Problema inesperado no sistema. Tente novamente mais tarde!"];
	}

	/**
	 * Recebe o ID do interesse sendo comentado e a FLAG da ultima mensagem mostrada, 
	 * retornando todas as restantes mensagens ainda não vistas
	 * @param  int   $idInteresse ID do interesse
	 * @param  int   $idFlagChat  ID da msg do chat
	 * @return array              Array com todas as mensagens
	 */
	public function novasMensagens($idInteresse, $idFlagChat){
		try{
			$sql = "
				SELECT * 
				FROM (
					SELECT 
						*,
						DATE_FORMAT(chat_data, '%d/%m %H:%i') as chat_data_formatada
					FROM chat
					WHERE interesse_id = $idInteresse AND chat_id > $idFlagChat
					ORDER BY chat_id DESC
				) X
				ORDER BY x.chat_id ASC
			";

			if(!$query = $this->db->query($sql))
				return ["tipo" => "erro", "msg" => "Não foi possivel buscar as mensagens."];
			else{
				if(!count($query->result())) 
					return;

				$this->atualizaVisualizacaoMsg($idInteresse);

				$i = 0;
				while($i<count($query->result())){
					foreach($query->result()[$i] as $campo => $valor)
						$dados[$i][$campo] = $valor;

					$i++;
				}

				return $dados;
			}
		}catch(PDOException $PDOE){
			return ["tipo" => "erro", "msg" => "Problema ao processar os dados no sistema. - Código: " . $PDOE->getCode()];
		}catch(Exception $NE){
			return ["tipo" => "erro", "msg" => "Problema ao executar a tarefa no sistema. - Código: " . $NE->getCode()];
		}

		return ["tipo" => "erro", "msg" => "Problema inesperado no sistema. Tente novamente mais tarde!"];
	}

	/**
	 * Atualiza as mensagens vistas pelo usuário
	 * @param  int  $idInteresse ID do interesse
	 * @param  int  $tipoPessoa  Tipo da pessoa visualisando
	 * @return bool              True se OK, false se Não
	 */
	private function atualizaVisualizacaoMsg($idInteresse){
		try{
			if($this->tipoPessoa == "Doador") $sql = "
				UPDATE interesse SET
					chat_lst_msg_doador = (
						SELECT max(chat_id) 
						FROM chat 
						WHERE interesse_id = $idInteresse AND chat_quem = 'Beneficiário'
					)
				WHERE interesse_id = $idInteresse";
			else $sql = "
				UPDATE interesse SET
					chat_lst_msg_beneficiario = (
						SELECT max(chat_id) 
						FROM chat 
						WHERE interesse_id = $idInteresse AND chat_quem = 'Doador'
					)
				WHERE interesse_id = $idInteresse";

			if($query = $this->db->query($sql)) return true;
			else return false;
		}catch(PDOException $PDOE){
			return false;
		}catch(Exception $NE){
			return false;
		}

		return false;
	}

	/**
	 * Retorna a quantidade de mensagens não lidas ainda
	 * @param  int $idItem  ID do item
	 * @return array        Todas as quantidades
	 */
	public function qtdeMsgsNaoLidasDoador($idItem){
		try{
			$sql = "
				SELECT 
					count(*) as num,
					i.usuario_id, i.interesse_id
				FROM interesse i NATURAL LEFT JOIN usuario u LEFT JOIN chat c ON c.interesse_id = i.interesse_id
				WHERE i.item_id = $idItem AND IF(i.chat_lst_msg_doador is null, 0, i.chat_lst_msg_doador) < c.chat_id
				GROUP BY u.usuario_id, i.interesse_id
			";

			if(!$query = $this->db->query($sql))
				return ["tipo" => "erro", "msg" => "Não foi possivel realizar a contagem."];
			else{
				if(!count($query->result())) 
					return;

				$i = 0;
				while($i<count($query->result())){
					$res = $query->result()[$i];

					$dados[$res->interesse_id] = [
						"usuario_id" => $res->usuario_id,
						"num" 		 => $res->num
					];

					$i++;
				}

				return $dados;
			}
		}catch(PDOException $PDOE){
			return ["tipo" => "erro", "msg" => "Problema ao processar os dados no sistema. - Código: " . $PDOE->getCode()];
		}catch(Exception $NE){
			return ["tipo" => "erro", "msg" => "Problema ao executar a tarefa no sistema. - Código: " . $NE->getCode()];
		}

		return ["tipo" => "erro", "msg" => "Problema inesperado no sistema. Tente novamente mais tarde!"];
	}

	/**
	 * Cancela um bate-papo
	 * @param  int $idInteresse   ID do interesse do baate-papo
	 * @return array              Array com a resposta
	 */
	public function cancelarBatePapo($idInteresse){
		if(!isset($idInteresse))
			return ["tipo" => "erro", "msg" => "Informação insufuciente para realizar a atualização."];

		try{
			$sql = "UPDATE interesse SET chat_bloqueado = 1 WHERE interesse_id = $idInteresse";

			if(!$query = $this->db->query($sql))
				return ["tipo" => "erro", "msg" => "Não foi possivel cancelar o bate-papo."];
			else return ["tipo" => "sucesso", "msg" => "OK"];
		}catch(PDOException $PDOE){
			return ["tipo" => "erro", "msg" => "Problema ao processar os dados no sistema. - Código: " . $PDOE->getCode()];
		}catch(Exception $NE){
			return ["tipo" => "erro", "msg" => "Problema ao executar a tarefa no sistema. - Código: " . $NE->getCode()];
		}

		return ["tipo" => "erro", "msg" => "Problema inesperado no sistema. Tente novamente mais tarde!"];
	}
}