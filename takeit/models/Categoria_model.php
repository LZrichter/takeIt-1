<?php defined('BASEPATH') OR exit('OPSSS... Não é permitido direto acesso ao script!!');

class Categoria_model extends CI_Model {

	public function __construct() {
		parent::__construct();
		$this->load->database();
	}

	/**
	 * Busca no Banco de Dados todas as categorias e as retorna
	 * @return 				Array com os dados buscados das categorias ou mensagem de erro
	 *	Array format:
	 *		array(
	 *			array(
	 *				"categoria_id" => "",
	 *				"categoria_nome" => ""
	 *			),
	 *			...
	 *		)
	 *	Ou:
	 *		array(
	 *			"Error" => ""
	 *		)
	 */
	public function buscaCategorias(){
		try{
			$sql = "SELECT categoria_id, categoria_nome	FROM categoria";

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

	public function buscaCategoriaPorId($id){
		if (!isset($id)) {
			return array("tipo" => "erro", "msg" => "Categoria não informada para a busca");
		}

		try{
			$sql = "SELECT categoria_nome FROM categoria WHERE categoria_id =".$id;

			if(!$query = $this->db->query($sql)){
				if($this->db->error()){
					return ["tipo" => "erro", "msg" => "Não foi possivel buscar a categoria"];
				}
			} else if (empty($query->result())) {
				return ["tipo" => "erro", "msg" => "Categoria não encontrada"];
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
			
		}catch(PDOException $PDOE){
			return ["tipo" => "erro", "msg" => "Problema ao processar os dados no sistema. - Código: " . $PDOE->getCode()];
		}catch(Exception $NE){
			return ["tipo" => "erro", "msg" => "Problema ao executar a tarefa no sistema. - Código: " . $NE->getCode()];
		}
	}
}