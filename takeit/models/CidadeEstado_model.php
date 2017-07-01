<?php defined('BASEPATH') OR exit('OPSSS... Não é permitido direto acesso ao script!!');

class CidadeEstado_model extends CI_Model{

	function __construct(){
		parent::__construct();

		$this->load->database();
	}

	/**
	 * Busca todas as cidade do banco de dados para serem apresentadas no select
	 * @return array Array com todos os dados das cidades
	 */
	public function todasCidades(){
		try{
			if(!$query = $this->db->query("SELECT * FROM cidade")){
				if($error = $this->db->error()){
					return ["tipo" => "erro", "msg" => "Ocorreu um erro na tentativa de buscar as cidades. Código: $error[code]"];
				}
			}else{
				foreach($query->result()[0] as $campo => $valor){
					$campo = str_replace("cidade_", "", $campo);
					$dados[$campo] = $this->$campo = $valor;
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
	 * Seleciona cidades baseado no estado que é passado
	 * @param  int    $id_estado ID do estado a ser buscado as cidades
	 * @return array Array com todos os dados das cidades selecionadas
	 */
	public function selecionaCidades(int $id_estado){
		if(!isset($id_estado) || empty($id_estado) || !is_int($id_estado))
			return ["tipo" => "erro", "msg" => "Dados não informado"];

		try{
			if(!$query = $this->db->query("SELECT * FROM cidade WHERE estado_id = $id_estado")){
				if($error = $this->db->error())
					return ["tipo" => "erro", "msg" => "Ocorreu um erro na tentativa de buscar as cidades. Código: $error[code]"];
			}else{
				$dados = [];
				
				foreach($query->result() as $linha => $val){
					$dados[] = ["id" => $val->cidade_id, "nome" => $val->cidade_nome];
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
	 * Busca todas os estados do banco de dados para serem apresentadas no select
	 * @return array Array com todos os dados dos estados
	 */
	public function todosEstados(){
		try{
			if(!$query = $this->db->query("SELECT * FROM estado")){
				if($error = $this->db->error())
					return ["tipo" => "erro", "msg" => "Ocorreu um erro na tentativa de buscar os estados. Código: $error[code]"];
			}else{
				foreach($query->result() as $linha => $val){
					$dados[] = ["id" => $val->estado_id, "uf" => $val->estado_uf];
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
	 * Busca o nome de um estado com base no id de uma cidade
	 * @param $idCidade [ id da cidade a ser buscado ]
	 * @return String com o nome do estado
	 */
	public function nomeEstado($idCidade){

		try{
			if(!$query = $this->db->query("SELECT estado_uf FROM estado NATURAL JOIN cidade c WHERE c.cidade_id =".$this->db->escape($idCidade))){
				if($error = $this->db->error())
					return ["tipo" => "erro", "msg" => "Ocorreu um erro na tentativa de buscar os estados. Código: $error[code]"];
			}else{
				$count = 0;
				foreach($query->result() as $row){
					foreach ($row as $campo => $valor) {
						$result[$count][$campo] = $valor;
					}
					$count++;
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

} ?>