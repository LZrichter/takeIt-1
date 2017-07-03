<?php defined('BASEPATH') OR exit('OPSSS... Não é permitido direto acesso ao script!!');

class Interesse_model extends CI_Model{

	function __construct(){
		parent::__construct();
	}

	/**
	 * Testará se um usuário possui um interesse aberto em um item
	 * @param  int    $idItem    ID do item a ser testado
	 * @param  int    $idUsuario ID do usuário a ser verificado
	 * @return bool              TRUE se o usuário possui um interesse, FALSE se não
	 */
	public function testaInteresseItem(int $idItem, int $idUsuario){
		if((!isset($idItem) || empty(trim($idItem))) || (!isset($idUsuario) || empty(trim($idUsuario))))
			return false;

		try{
			$sql = "SELECT interesse_id FROM interesse WHERE item_id = $idItem and usuario_id = $idUsuario";

			if(!$query = $this->db->query($sql))
				return false;
			else{
				if(!count($query->result())) 
					return false;

				return true;
			}		
		}catch(PDOException $PDOE){
			return false;
		}catch(Exception $NE){
			return false;
		}

		return false;
	}

	/**
	 * Busca um array com todos os usuários que demonstraram interesse em um item
	 * @param  int    $idItem ID do item a ser buscado
	 * @return array          Array com os dados ou com uma mensagem de erro
	 */
	public function todosInteressados(int $idItem){
		if(!isset($idItem) || empty(trim($idItem)))
			return array("tipo" => "erro", "msg" => "Informação insuficiente para executar a consulta.");

		try{
			$sql = "
				SELECT 
					usuario_id, usuario_nome, usuario_nivel, 
					interesse_id, chat_lst_msg_doador, 
					concat(imagem_caminho, '/', imagem_nome) as imagem_caminho
				FROM interesse NATURAL LEFT JOIN usuario NATURAL LEFT JOIN imagem
				WHERE item_id = $idItem;
			";

			if(!$query = $this->db->query($sql))
				return ["tipo" => "erro", "msg" => "Não foi possivel buscar a lista de interessados."];
			else{
				if(!count($query->result())) 
					return ["tipo" => "erro", "msg" => "Nenhuma pessoa demonstrou interesse no seu item ainda."];

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

	public function manifestarInteresse($item_id, $user_id){
		if(!isset($item_id) || !isset($user_id)) 
			return ["tipo" => "erro", "msg" => "Parâmetros insuficientes para executar a função."];

		try{
			$this->db->trans_begin();
			$sql = "INSERT INTO interesse (interesse_data, item_id, usuario_id) VALUES (
						".$this->db->escape(date("Y-m-d H:i:s")).", 
						".$this->db->escape($item_id).", 
						".$this->db->escape($user_id).")";
			
			if(!$query = $this->db->query($sql)){
				if($error = $this->db->error()){
					$this->db->trans_rollback();
					return ["tipo" => "erro", "msg" => "Não foi possivel inserir seu interesse"];
				}
			}else{
				$this->db->trans_commit();
				return ["tipo" => "sucesso"];
			}

		}catch(PDOException $PDOE){
			return ["tipo" => "erro", "msg" => "Problema ao processar os dados no sistema. - Código: " . $PDOE->getCode()];
		}catch(Exception $NE){
			return ["tipo" => "erro", "msg" => "Problema ao executar a tarefa no sistema. - Código: " . $NE->getCode()];
		}
	}

	public function removerInteresse($item_id, $user_id){
		if(!isset($item_id) || !isset($user_id)) 
			return ["tipo" => "erro", "msg" => "Parâmetros insuficientes para executar a função."];

		try{
			$this->db->trans_begin();
			$sql = "DELETE FROM interesse WHERE item_id = ".$this->db->escape($item_id)." AND usuario_id = ".$this->db->escape($user_id);
			
			if(!$query = $this->db->query($sql)){
				if($error = $this->db->error()){
					$this->db->trans_rollback();
					return ["tipo" => "erro", "msg" => "Não foi possivel remover seu interesse"];
				}
			}else{
				$this->db->trans_commit();
				return ["tipo" => "sucesso"];
			}

		}catch(PDOException $PDOE){
			return ["tipo" => "erro", "msg" => "Problema ao processar os dados no sistema. - Código: " . $PDOE->getCode()];
		}catch(Exception $NE){
			return ["tipo" => "erro", "msg" => "Problema ao executar a tarefa no sistema. - Código: " . $NE->getCode()];
		}
	}
}