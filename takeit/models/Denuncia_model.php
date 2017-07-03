<?php defined('BASEPATH') OR exit('OPSSS... Não é permitido direto acesso ao script!!');

class Denuncia_model extends CI_Model{
	
	function __construct(){
		parent::__construct();
		$this->load->database();
	}

	/**
	 * Descrição: Lista as denuncias classificadas por status se o parâmetro for passado
	 * @param  [String] $denuncia_status [Status da denuncia]
	 * @return [array]  $array("tipo" => "erro | sucesso", "msg" => "mensagem de retorno");
	 */
	function listaDenuncias($denuncia_status = null){
		if (is_null($denuncia_status)) {
			$sql = "SELECT * FROM denuncia";	
		}else if (is_array($denuncia_status)) {
			$sql = 'SELECT * FROM denuncia WHERE denuncia_status=';
					foreach ($denuncia_status as $key => $value){
						if( $key == count($denuncia_status)-1 )
							$sql .= $this->db->escape($value);	
						else
							$sql .= $this->db->escape($value)." OR denuncia_status=";
					}
		}else{
			$sql = "SELECT * FROM denuncia WHERE denuncia_status =".$this->db->escape($denuncia_status);
		}
		

		try{
			$result = array();
			if(!$query = $this->db->query($sql)){
				if($this->db->error()){
					return array("tipo" => "erro", "msg" => $this->db->_error_message());
				}
			}else {
				$count = 0;
				foreach($query->result() as $row){
					foreach ($row as $campo => $valor) {
						$result[$count][$campo] = $valor;
					}
					$count++;
				}
				return $result;
			}

		}catch(Exception $E){
			return array("tipo" => "erro", "msg" => "Erro inexperado ao realizar a consulta, por favor tenta mais tarde!!!");
		}
	}

	/**
	 * Descrição: Insere dados na tabela de denuncia
	 * @param  [array] $dados [Dados a serem inseridos na denuncia]
	 * 
	 * se "item_vacilao" for setado será uma denuncia de item
	 * 	  array(
	 * 		"denuncia_text" => "motivo da denuncia", "usuario_xnove" => "id User denunciante", 
	 * 	 	"usuario_vacilao" => "id User denunciado", "item_vacilao" => "id item denunciado"
	 *    );
	 * se "item_vacilao" não for setado será uma denuncia de usuario somente
	 * 
	 * @return boolean | array de erro ["tipo" => "erro", "msg" => "mensagem de erro"] 
	 */
	function insereDenuncia($dados){
		if(!isset($dados['denuncia_text']) || !isset($dados['usuario_xnove']) || !isset($dados['usuario_vacilao'])){
			return array("tipo" => "erro", "msg" => "Informação insuficiente para executar a consulta.");
		}else if (isset($dados['item_vacilao']) && $dados['item_vacilao']!='') {
			$sql = "INSERT INTO denuncia (denuncia_text, denuncia_data, denuncia_status, usuario_xnove, usuario_vacilao, item_vacilao) 
				values ("
					.$this->db->escape($dados['denuncia_text']).","
					.$this->db->escape(date('Y:m:d')).","
					.$this->db->escape('Aberta').", "
					.$this->db->escape($dados['usuario_xnove']).", "
					.$this->db->escape($dados['usuario_vacilao']).", "
					.$this->db->escape($dados['item_vacilao']).
				")";
		}else{
			$sql = "INSERT INTO denuncia (denuncia_text, denuncia_data, denuncia_status, usuario_xnove, usuario_vacilao) 
				values ("
					.$this->db->escape($dados['denuncia_text']).","
					.$this->db->escape(date('Y:m:d')).","
					.$this->db->escape('Aberta').", "
					.$this->db->escape($dados['usuario_xnove']).", "
					.$this->db->escape($dados['usuario_vacilao']).
				")";
		}

		try{

			if(!$query = $this->db->query($sql)){
				if($this->db->error()){
					return array("tipo" => "erro", "msg" => $this->db->_error_message());
				}
			}else{
				return TRUE;
			}
				
		}catch(Exception $NE) {
			return array("tipo" => "erro", "msg" => "Problema ao executar a tarefa no sistema. - Código: " . $NE->getCode());
		}catch(PDOException $PDOE){
			return array("tipo" => "erro", "msg" => "Problema ao processar os dados no sistema. - Código: " . $PDOE->getCode());
		}
	}

	/**
	 * Muda o status de uma denuncia para 'Ignorada'
	 * @param  [int] $idDenuncia [id da denuncia a ser ignorada]
	 * @return [bool | array]	[ TRUE se for alterada com sucesso, array("tipo" => "erro", "msg" => "mensagem de erro")]
	 */
	function ignorarDenuncia($idDenuncia){
		if(!isset($idDenuncia)){
			return array("tipo" => "erro", "msg" => "Informação insuficiente para executar a consulta.");
		}

		try{

			$sql = "UPDATE denuncia SET denuncia_status = ".$this->db->escape('Ignorada')." WHERE denuncia_id = ".$this->db->escape($idDenuncia);

			if(!$query = $this->db->query($sql)){
				if($this->db->error()){
					return array("tipo" => "erro", "msg" => $this->db->_error_message());
				}
			} else {
				return true;
			}
			
		}catch(Exception $NE) {
			return array("tipo" => "erro", "msg" => "Problema ao executar a tarefa no sistema. - Código: " . $NE->getCode());
		}catch(PDOException $PDOE){
			return array("tipo" => "erro", "msg" => "Problema ao processar os dados no sistema. - Código: " . $PDOE->getCode());
		}
	}


	/**
	 * Muda o status de uma denuncia para 'Resolvida'
	 * @param  [int] $idDenuncia [id da denuncia a ser ignorada]
	 * @param  [int] [Se for setado irá marcar como 'Resolvida' todas as denúncias do usuario corespondente]
	 * @return [bool | array]	[ TRUE se for alterada com sucesso, array("tipo" => "erro", "msg" => "mensagem de erro")]
	 */
	function resolverDenuncia($idDenuncia, $idUser = NULL){
		if(!isset($idDenuncia) && is_null($idUser)){
			return array("tipo" => "erro", "msg" => "Informação insuficiente para executar a consulta.");
		}
		else if(!isset($idDenuncia) && !is_null($idUser)){
			$sql = "UPDATE denuncia SET denuncia_status = ".$this->db->escape('Resolvida')." WHERE usuario_vacilao = ".$this->db->escape($idUser);
		}
		else if(isset($idDenuncia) && is_null($idUser)){
			$sql = "UPDATE denuncia SET denuncia_status = ".$this->db->escape('Resolvida')." WHERE denuncia_id = ".$this->db->escape($idDenuncia);
		}
		else{
			return false;
		}

		try{

			if(!$query = $this->db->query($sql)){
				if($this->db->error()){
					return array("tipo" => "erro", "msg" => $this->db->_error_message());
				}
			}else {
				return true;
			}
			
		}catch(Exception $NE) {
			return array("tipo" => "erro", "msg" => "Problema ao executar a tarefa no sistema. - Código: " . $NE->getCode());
		}catch(PDOException $PDOE){
			return array("tipo" => "erro", "msg" => "Problema ao processar os dados no sistema. - Código: " . $PDOE->getCode());
		}
	}
}