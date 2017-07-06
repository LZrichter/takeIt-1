<?php defined('BASEPATH') OR exit('OPSSS... Não é permitido direto acesso ao script!!');

class Doacao_model extends CI_Model {

    public function __construct() {
        parent::__construct();

        $this->load->database();
    }

	/**
	 * Insere no Banco de Dados uma doacao
	 * @param  $dados 	Array com os dados necessários para a realização da inserção
	 *	Array format:
	 *		array(
	 *			"quantidade" => "",
	 *			"interesse_id" => "",
	 *			"agradecimento" => ""
	 *		)
	 * @return 			Boolean indicando o sucesso da inserção ou array com mensagem de erro
	 *	Array format:
	 *		array(
	 *			"Error" => ""
	 *		)
	 */
	public function registraDoacao($dados){
		if(!isset($dados['quantidade']) || !isset($dados['interesse_id'])){
			return ["tipo" => "erro", "msg" => "Sem informações suficientes para realizar a doação, tente novamente mais tarde!"];
		}

		try{
			$sql = "
				INSERT INTO doacao (doacao_qtde, doacao_data, interesse_id, doacao_agradecimento) 
				VALUES (
					".$this->db->escape($dados['quantidade']).",
					'".date('Y-m-d')."',
					".$this->db->escape($dados['interesse_id']).",
					".$this->db->escape($dados['agradecimento'])."
				)
			";

			if(!$query = $this->db->query($sql)){
				if($this->db->error()){
					return ["tipo" => "erro", "msg" => "Não foi possivel realizar a doação, tente novamente mais tarde."];
				}
			}else return true;
		}catch(PDOException $PDOE){
			return ["tipo" => "erro", "msg" => "Problema ao processar os dados no sistema. - Código: " . $PDOE->getCode()];
		}catch(Exception $NE){
			return ["tipo" => "erro", "msg" => "Problema ao executar a tarefa no sistema. - Código: " . $NE->getCode()];
		}

		return ["tipo" => "erro", "msg" => "Problema inesperado no sistema. Tente novamente mais tarde!"];
	}

	/**
	 * Altera o agradecimento de uma doacao no Banco de Dados
	 * @param 	$idDoacao	ID da doacao a ser alterada
	 * @param  	$novoAgra 	Novo agradecimento
	 * @return 				Boolean indicando o sucesso da alteração ou array com mensagem de erro
	 *	Array format:
	 *		array(
	 *			"Error" => ""
	 *		)
	 */
	public function alteraAgradecimento($idDoacao, $novoAgra){
		if(!isset($idDoacao) || !isset($novoAgra)){
			return array("Error" => "Insuficient information to execute the query");
		}

		try{

			$sql = "UPDATE doacao SET doacao_agradecimento = ".$novoAgra." 
			WHERE doacao_id = ".$idDoacao;

			if(!$query = $this->db->query($sql)){
				if($this->db->error()){
					return array("Error" => "$error[message]");
				}
			} else {
				return true;
			}
			
		} catch(Exception $E) {
			return array("Error" => "Server was unable to execute query");
		}
	}

	/**
	 * Busca no Banco de Dados os dados de uma doação realizada e os retorna
	 * @param 	$idDoacao	ID da doação a ser buscada
	 * @return 				Array com os dados buscados da doação ou mensagem de erro
	 *	Array format:
	 *		array(
	 *			"doacao_qtde" => "",
	 *			"doacao_data" => "",
	 *			"interesse_id" => "",
	 *			"doacao_agradecimento" => ""
	 *		)
	 *	Ou:
	 *		array(
	 *			"Error" => ""
	 *		)
	 */
	public function buscaDoacao($idDoacao){
		if(!isset($idDoacao)){
			return array("Error" => "Insuficient information to execute the query");
		}

		try{

			$sql = "SELECT doacao_qtde, doacao_data, interesse_id, doacao_agradecimento FROM doacao
			WHERE doacao_id = ".$idDoacao;

			if(!$query = $this->db->query($sql)){
				if($this->db->error()){
					return array("Error" => "$error[message]");
				}
			} else {
				return true;
			}
			
		}catch(PDOException $PDOE){
			return ["tipo" => "erro", "msg" => "Problema ao processar os dados no sistema. - Código: " . $PDOE->getCode()];
		}catch(Exception $NE){
			return ["tipo" => "erro", "msg" => "Problema ao executar a tarefa no sistema. - Código: " . $NE->getCode()];
		}

		return ["tipo" => "erro", "msg" => "Problema inesperado no sistema. Tente novamente mais tarde!"];
	}

	/**
	 * Busca no Banco de Dados as doações e as retorna
	 * @return 				Array com os dados buscados das doações ou mensagem de erro
	 *	Array format:
	 *		array(
	 *			array(
	 *				"doacao_id" => "",
	 *				"doacao_qtde" => "",
	 *				"doacao_data" => "",
	 *				"interesse_id" => ""
	 *			),
	 *			...
	 *		)
	 *	Ou:
	 *		array(
	 *			"Error" => ""
	 *		)
	 */
	public function buscaDoacoes(){
		try{
			$sql = "SELECT DISTINCT doacao_id, doacao_qtde, doacao_data, interesse_id FROM doacao";

			if(!$query = $this->db->query($sql)){
				if($this->db->error()){
					return array("Error" => "$error[message]");
				}
			} else if (empty($query->result())) {
				return array("Error" => "No data found");
			} else {
				$count = 0;
				foreach($query->result() as $row){
					foreach ($row as $campo => $valor) {
						$result[$count][$campo] = $valor;
					}
					$count++;
				}
				return $result;
			}
		} catch(Exception $E) {
			return array("Error" => "Server was unable to execute query");
		}
    }

    /**
     * Busca no banco de dados as doações recebidas para o usuario passado por parametro
     * @param int -> id do usuario a ser buscado
     * @return array() -> array com os dados ou com mensagem de erro.
     */
    public function buscaDoados($idUser){
		if(!isset($idUser))
			return ["tipo" => "erro", "msg" => "Informação insufuciente para realizar a consulta."];

		try{
			$sql = "SELECT d.doacao_qtde, d.doacao_data, d.interesse_id, d.doacao_agradecimento, it.*,
			(SELECT imagem_caminho FROM imagem WHERE imagem.item_id = it.item_id LIMIT 1) AS imagem_caminho , 
			(SELECT imagem_nome FROM imagem WHERE imagem.item_id = it.item_id LIMIT 1) AS imagem_nome
			FROM doacao d
			JOIN interesse i ON d.interesse_id = i.interesse_id
			JOIN item it 	 ON i.item_id = it.item_id
			WHERE i.usuario_id = ".$this->db->escape($idUser);

			if(!$query = $this->db->query($sql)){
				if($this->db->error()){
					return array("tipo" => "erro", "msg" => $this->db->_error_message());
				}
			} else {
				$result = array();
				$i = 0;
				foreach($query->result() as $row){
					foreach ($row as $campo => $valor) {
						$result[$i][$campo] = $valor;
					}
					$i++;
				}
				return $result;
			}
			
		}catch(PDOException $PDOE){
			return ["tipo" => "erro", "msg" => "Problema ao processar os dados no sistema. - Código: " . $PDOE->getCode()];
		}catch(Exception $NE){
			return ["tipo" => "erro", "msg" => "Problema ao executar a tarefa no sistema. - Código: " . $NE->getCode()];
		}

		return ["tipo" => "erro", "msg" => "Problema inesperado no sistema. Tente novamente mais tarde!"];
	}

	/**
	 * Busca a quantidade de itens que foram doados até o momento
	 * @param  int $itemId ID do item
	 * @return int         Numero de itens doados
	 */
	public function qtdeDoadaItem($itemId){
		if(!isset($itemId))
			return ["tipo" => "erro", "msg" => "Informação insufuciente para realizar a consulta."];

		try{
			$sql = "
				SELECT SUM(d.doacao_qtde) as total_qtde
				FROM doacao d LEFT JOIN interesse i ON i.interesse_id = d.interesse_id
				WHERE i.item_id = $itemId
			";
		if(!$query = $this->db->query($sql)) return 0;
		else{
			if(!count($query->result())) 
				return;

			$num = $query->result()[0]->total_qtde;

			return (is_null($num) ? 0 : $num);

		}
		}catch(PDOException $PDOE){
			return 0;
		}catch(Exception $NE){
			return 0;
		}
		return 0;
	}

	/**
	 * Verifica se usuário possui uma doação já cadastrada para ele naquele item
	 * @param  int $idUsuario ID do usuário
	 * @param  int $idItem    ID do item
	 * @return bool           TRUE se sim, FALSE se não
	 */
	public function possuiDoacaoitem($idUsuario, $idItem){
		if(!isset($idUsuario) || !isset($idItem))
			return ["tipo" => "erro", "msg" => "Informação insufuciente para realizar a consulta."];

		try{
			$sql = "
				SELECT count(*) as doacao
				FROM doacao d LEFT JOIN interesse i ON d.interesse_id = i.interesse_id
				WHERE i.item_id = $idItem AND i.usuario_id = $idUsuario
			";

			if(!$query = $this->db->query($sql)) return false;
			else{
				if(!count($query->result())) 
					return false;

				$num = $query->result()[0]->doacao;

				return (is_null($num) ? false : ($num > 0 ? true : false));
			}
		}catch(PDOException $PDOE){
			return false;
		}catch(Exception $NE){
			return false;
		}

		return false;
	}

	/**
	 * Função que cadastra um agradecimento a uma doação
	 * @param int $idInteresse -> id do interesse da doacao
	 * @return array com erros | boolean TRUE no sucesso da inserção do agradecimento
	 */
	public function agradecerDoacao($idInteresse){
		if(!isset($idInteresse)){
			return ["tipo" => "erro", "msg" => "Informação insufuciente para realizar a consulta."];
		}

		try{

			$count = $this->db->query("SELECT * FROM doacao WHERE interesse_id = $idInteresse ");
			$sql = "UPDATE doacao SET 
				doacao_agradecimento = $this->db->escape($agradecimento) WHERE interesse_id = $idInteresse";

			foreach($count->result() as $row){
				foreach ($row as $campo => $valor) {
					if ($campo == 'doacao_agradecimento' && empty($valor)) {
						$this->db->query($sql);
						return TRUE;								
					}
				}
			}

		}catch(PDOException $PDOE){
			return ["tipo" => "erro", "msg" => "Problema ao processar os dados no sistema. - Código: " . $PDOE->getCode()];
		}catch(Exception $NE){
			return ["tipo" => "erro", "msg" => "Problema ao executar a tarefa no sistema. - Código: " . $NE->getCode()];
		}
	}

	/**
	 * Função que verifica se uma doação ja foi agradecida
	 * @param int $idInteresse -> id do interesse da doacao
	 * @return array com erros | boolean TRUE se o a doação ja foi agradecida
	 */
	public function verificarAgradecimento($idInteresse){
		if(!isset($idInteresse)){
			return ["tipo" => "erro", "msg" => "Informação insufuciente para realizar a consulta."];
		}

		try{

			$count = $this->db->query("SELECT * FROM doacao WHERE interesse_id = $idInteresse ");

			foreach($count->result() as $row){
				foreach ($row as $campo => $valor) {
					if ($campo == 'doacao_agradecimento' && !empty($valor)) {
						return TRUE;								
					}
				}
			}

		}catch(PDOException $PDOE){
			return ["tipo" => "erro", "msg" => "Problema ao processar os dados no sistema. - Código: " . $PDOE->getCode()];
		}catch(Exception $NE){
			return ["tipo" => "erro", "msg" => "Problema ao executar a tarefa no sistema. - Código: " . $NE->getCode()];
		}

		return ["tipo" => "erro", "msg" => "Problema inesperado no sistema. Tente novamente mais tarde!"];
	}

}