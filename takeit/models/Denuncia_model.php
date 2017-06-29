<?php defined('BASEPATH') OR exit('OPSSS... Não é permitido direto acesso ao script!!');

class Denuncia_model extends CI_Model{
	
	function __construct(){
		parent::__construct();
		$this->load->database();
	}

	function listaDenuncias($denuncia_status = null){
		if (is_null($denuncia_status)) {
			$sql = "SELECT * FROM denuncia";	
		}else if (is_array($denuncia_status)) {
			$sql = 'SELECT * FROM denuncia AND item_status=';
					foreach ($status as $key => $value){
						if( $key == count($status)-1 )
							$sql .= $this->db->escape($value);	
						else
							$sql .= $this->db->escape($value)." OR item_status=";
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


	function insereDenuncia($dados){
		if(!isset($dados['denuncia_text']) || !isset($dados['usuario_xnove']) || !isset($dados['usuario_vacilao']) || !isset($dados['item_vacilao'])){
			return array("tipo" => "erro", "msg" => "Informação insuficiente para executar a consulta.");
		}

		try{
				$sql = "INSERT INTO denuncia (denuncia_text, denuncia_data, denuncia_status, usuario_xnove, usuario_vacilao, item_vacilao) 
				values ("
					.$this->db->escape($dados['denuncia_text']).","
					.$this->db->escape(date('Y:m:d')).","
					.$this->db->escape('Aberta').", "
					.$this->db->escape($dados['usuario_xnove']).", "
					.$this->db->escape($dados['usuario_vacilao']).", "
					.$this->db->escape($dados['item_vacilao']).
				")";

				if(!$query = $this->db->query($sql)){
					if($this->db->error()){
						return array("tipo" => "erro", "msg" => $this->db->_error_message());
					}
				}else{
					$lastId = $this->db->insert_id();
					return array("tipo" => "sucesso", "msg" => "O item foi reportado com sucesso", "idItem" => $lastId);
				}
				
			}catch(Exception $NE) {
				return array("tipo" => "erro", "msg" => "Problema ao executar a tarefa no sistema. - Código: " . $NE->getCode());
			}catch(PDOException $PDOE){
				return array("tipo" => "erro", "msg" => "Problema ao processar os dados no sistema. - Código: " . $PDOE->getCode());
			}
	}

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

	function resolverDenuncia($idDenuncia){
		if(!isset($idDenuncia)){
			return array("tipo" => "erro", "msg" => "Informação insuficiente para executar a consulta.");
		}

		try{

			$sql = "UPDATE denuncia SET denuncia_status = ".$this->db->escape('Resolvida')." WHERE denuncia_id = ".$this->db->escape($idDenuncia);

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
}