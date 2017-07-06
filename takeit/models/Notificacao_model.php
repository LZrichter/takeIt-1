<?php defined('BASEPATH') OR exit('OPSSS... Não é permitido direto acesso ao script!!');

class Notificacao_model extends CI_Model {

	public function __construct() {
			parent::__construct();

			$this->load->database();
	}

	/**
	 * Busca no Banco de Dados todas as notificações de um usuário e as retorna
	 * @param 	$idUsuario
	 * @return 	Array com os dados buscados das notificacoes ou mensagem de erro
	 *	Array format:
	 *		array(
	 *			array(
	 *				"notificacao_id" => "",
	 *				"notificacao_tipo" => "",
	 *				"notificacao_lida" => "",
	 *				"interesse_id" => "",
	 *				"usuario_id" => "",
	 *				"usuario_nome" => "",
	 *				"usuario_id_interesse" => "",
	 *				"usuario_nome_interesse" => "",
	 *				"item_id" => "",
	 *				"item_descricao" => ""
	 *			),
	 *			...
	 *		)
	 *	Ou:
	 *		array(
	 *			"Error" => ""
	 *		)
	 */
	public function buscaNotificacoes($idUsuario){

		try{

			$sql = "SELECT notificacao_id, notificacao_tipo, notificacao_lida, i.interesse_id, it.usuario_id, 
			u.usuario_nome, u2.usuario_id AS usuario_id_interesse, u2.usuario_nome AS usuario_nome_interesse, 
			it.item_id, it.item_descricao 
			FROM notificacao n
			JOIN interesse i ON i.interesse_id = n.interesse_id
			JOIN item it ON it.item_id = i.item_id
			JOIN usuario u ON it.usuario_id = u.usuario_id
			JOIN usuario u2 ON u2.usuario_id = i.usuario_id
			WHERE u.usuario_id = ".$this->db->escape($idUsuario)." OR u2.usuario_id = ".$this->db->escape($idUsuario);

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
	 * Busca no Banco de Dados a quantidade de notificações de um usuário e as retorna
	 * @param 	$idUsuario
	 * @return 	Quantidade ou mensagem de erro
	 */
	public function quantidadeDeNotificacoes($idUsuario){

		try{

			$sql = "SELECT COUNT(*) as qtde FROM notificacao n
			JOIN interesse i ON i.interesse_id = n.interesse_id
			JOIN item it ON it.item_id = i.item_id
			JOIN usuario u ON it.usuario_id = u.usuario_id
			JOIN usuario u2 ON u2.usuario_id = i.usuario_id
			WHERE (u.usuario_id = ".$this->db->escape($idUsuario)." AND u2.usuario_id != ".$this->db->escape($idUsuario).")
			OR (u.usuario_id != ".$this->db->escape($idUsuario)." AND u2.usuario_id = ".$this->db->escape($idUsuario).");

			if(!$query = $this->db->query($sql)){
				if($this->db->error()){
					return array("Error" => "$error[message]");
				}
			} else if (empty($query->result())) {
				return array("Error" => "No data found");
			} else {

				$result["paginas_qtde"] = $query->result()[0]->qtde;
				
				return $result;
			}

		} catch(Exception $E) {
			return array("Error" => "Server was unable to execute query");
		}
	}	

}