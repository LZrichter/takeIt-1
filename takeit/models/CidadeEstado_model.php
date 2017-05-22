<?php defined('BASEPATH') OR exit('OPSSS... Não é permitido direto acesso ao script!!');

class CidadeEstado_model extends CI_Model{

	function __construct(){
		parent::__construct();

		$this->load->database();
		$this->load->helper('erro');
		$this->erro = new Erro();
	}

	/**
	 * Busca todas as cidade do banco de dados para serem apresentadas no select
	 * @return array Array com todos os dados das cidades
	 */
	public function todasCidades(){
		try{
			if(!$query = $this->db->query("SELECT * FROM cidade")){
				if($error = $this->db->error()){
					$this->erro("sql", "Ocorreu um erro na tentativa de buscar as cidades: $error[code] - $error[message]");

					return FALSE;
				}
			}else{
				foreach($query->result()[0] as $campo => $valor){
					$campo = str_replace("cidade_", "", $campo);
					$dados[$campo] = $this->$campo = $valor;
				}

				return $dados;
			}
		}catch(PDOException $PDOE){
			$this->erro("pdo", "Excessão: " . $PDOE->getCode() . " - " . $PDOE->getMessage());
			return FALSE;
		}catch(Exception $SysE){
			$this->erro("sys", "Excessão: " . $SysE->getCode() . " - " . $SysE->getMessage());
			return FALSE;
		}

		$this->erro("sys", "Ocorreu um erro inesperado no sistema.");
		return FALSE;
	}

	/**
	 * Seleciona cidades baseado no estado que é passado
	 * @param  int    $id_estado ID do estado a ser buscado as cidades
	 * @return array Array com todos os dados das cidades selecionadas
	 */
	public function selecionaCidades(int $id_estado){
		if(!isset($id_estado) || empty($id_estado) || !is_int($id_estado)){
			$this->erro("sys", "Variável passada não está correta.");
			return FALSE;
		}

		try{
			if(!$query = $this->db->query("SELECT * FROM cidade WHERE estado_id = $id_estado")){
				if($error = $this->db->error()){
					$this->erro("sql", "Ocorreu um erro na tentativa de buscar as cidades: $error[code] - $error[message]");

					return FALSE;
				}
			}else{
				$dados = [];
				
				foreach($query->result() as $linha => $val){
					$dados[] = ["id" => $val->cidade_id, "nome" => $val->cidade_nome];
				}

				return $dados;
			}
		}catch(PDOException $PDOE){
			$this->erro("pdo", "Excessão: " . $PDOE->getCode() . " - " . $PDOE->getMessage());
			return FALSE;
		}catch(Exception $SysE){
			$this->erro("sys", "Excessão: " . $SysE->getCode() . " - " . $SysE->getMessage());
			return FALSE;
		}

		$this->erro("sys", "Ocorreu um erro inesperado no sistema.");
		return FALSE;
	}

	/**
	 * Busca todas os estados do banco de dados para serem apresentadas no select
	 * @return array Array com todos os dados dos estados
	 */
	public function todosEstados(){
		try{
			if(!$query = $this->db->query("SELECT * FROM estado")){
				if($error = $this->db->error()){
					$this->erro("sql", "Ocorreu um erro na tentativa de buscar os estados: $error[code] - $error[message]");

					return FALSE;
				}
			}else{
				foreach($query->result() as $linha => $val){
					$dados[] = ["id" => $val->estado_id, "uf" => $val->estado_uf];
				}

				return $dados;
			}
		}catch(PDOException $PDOE){
			$this->erro("pdo", "Excessão: " . $PDOE->getCode() . " - " . $PDOE->getMessage());
			return FALSE;
		}catch(Exception $SysE){
			$this->erro("sys", "Excessão: " . $SysE->getCode() . " - " . $SysE->getMessage());
			return FALSE;
		}

		$this->erro("sys", "Ocorreu um erro inesperado no sistema.");
		return FALSE;
	}

} ?>