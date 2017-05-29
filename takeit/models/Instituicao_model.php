<?php defined('BASEPATH') OR exit('OPSSS... Não é permitido direto acesso ao script!!');

class Instituicao_model extends CI_Model {

    public function __construct() {
        parent::__construct();

        $this->load->database();
    }

	/**
	 * Insere no Banco de Dados uma instituição
	 * @param  $dados 	Array com os dados necessários para a realização da inserção
	 *	Array format:
	 *		array(
	 *			"idUsuario" => "",
	 *			"cnpj" => "",
	 *			"site" => ""
	 *		)
	 * @return 			Boolean indicando o sucesso da inserção ou array com mensagem de erro
	 *	Array format:
	 *		array(
	 *			"Error" => ""
	 *		)
	 */
	public function insereInstituicao($dados){
		if(!isset($dados['idUsuario']) || !isset($dados['cnpj']) || !isset($dados['site'])){
			return array("Error" => "Insuficient information to execute the query");
		}

		try{

			$sql = "INSERT INTO instituicao (instituicao_id, instituicao_cnpj, instituicao_site) 
			values (".$dados['idUsuario'].", ".$dados['cnpj'].", ".$dados['site'].")";

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
	 * Altera o cnpj e o site de uma instituição no Banco de Dados
	 * @param 	$idInst		ID da instituição a ser alterada
	 * @param  	$novoCnpj 	Novo CNPJ (duh)
	 * @param  	$novoSite 	Novo Site (duh)
	 * @return 				Boolean indicando o sucesso da alteração ou array com mensagem de erro
	 *	Array format:
	 *		array(
	 *			"Error" => ""
	 *		)
	 */
	public function alteraInstituicao($idInst, $novoCnpj, $novoSite){
		if(!isset($idInst) || !isset($novoCnpj) || !isset($novoSite)){
			return array("Error" => "Insuficient information to execute the query");
		}

		try{

			$sql = "UPDATE instituicao SET instituicao_cnpj = ".$novoCnpj.", instituicao_site = ".$novoSite." 
			WHERE instituicao_id = ".$idInst;

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
	 * Busca no Banco de Dados o CNPJ e site de uma instituição e os retorna
	 * @param 	$idInst		ID da instituição a ser buscada
	 * @return 				Array com os dados buscados da instituição ou mensagem de erro
	 *	Array format:
	 *		array(
	 *			"cnpjInst" => "",
	 *			"siteInst" => ""
	 *		)
	 *	Ou:
	 *		array(
	 *			"Error" => ""
	 *		)
	 */
	public function buscaInstituicao($idInst){
		if(!isset($idInst)){
			return array("Error" => "Insuficient information to execute the query");
		}

		try{

			$sql = "SELECT instituicao_cnpj, instituicao_site FROM instituicao
			WHERE instituicao_id = ".$idInst;

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
	 * Busca no Banco de Dados as instituições e as retorna
	 * @return 				Array com os dados buscados das instituições ou mensagem de erro
	 *	Array format:
	 *		array(
	 *			array(
	 *				"usuario_id" => "",
	 *				"usuario_nome" => "",
	 *				"cidade_nome" => "",
	 *				"estado_uf" => ""
	 *			),
	 *			...
	 *		)
	 *	Ou:
	 *		array(
	 *			"Error" => ""
	 *		)
	 */
    public function buscaInstituicoes(){ // Adicionar filtro por tipo_usuario quando ele for adicionado
    	
		try{

			$sql = "SELECT DISTINCT usuario_id, usuario_nome, cidade_nome, estado_uf
			FROM estado NATURAL JOIN cidade NATURAL JOIN usuario";

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
	 * Insere no Banco de Dados as categorias das quais uma instituição tem interesse
	 * @param 	$idInst		ID da instituição a ser buscada
	 * @param 	$categs 	Array com os ids das categorias a serem associadas
	 *	Array format:
	 *		array($idCat1, $idCat2,...)
	 * @return 			Boolean indicando o sucesso da inserção ou array com mensagem de erro
	 *	Array format:
	 *		array(
	 *			"Error" => ""
	 *		)
	 */
    public function associarInstituicaoCategorias(){
    	if(!isset($idInst) || !isset($categs)){
			return array("Error" => "Insuficient information to execute the query");
		}

		try{

			for($i = 0; $i < sizeof($categs); $i++){
				$sql = "INSERT INTO instituicao_categoria (instituicao_id, categoria_id) 
				values (".$idInst.", ".$categs[$i].")";
			}

			

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

}