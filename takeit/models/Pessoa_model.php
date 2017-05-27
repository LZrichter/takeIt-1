<?php defined('BASEPATH') OR exit('OPSSS... Não é permitido direto acesso ao script!!');

class Pessoa_model extends CI_Model {

    public function __construct() {
        parent::__construct();

        $this->load->database();
    }

	/**
	 * Insere no Banco de Dados uma pessoa
	 * @param  $dados 	Array com os dados necessários para a realização da inserção
	 *	Array format:
	 *		array(
	 *			"idUsuario" => "",
	 *			"cpf" => ""
	 *		)
	 * @return 			Boolean indicando o sucesso da inserção ou array com mensagem de erro
	 *	Array format:
	 *		array(
	 *			"Error" => ""
	 *		)
	 */
	public function inserePessoa($dados){
		if(!isset($dados['idUsuario']))
			return ["tipo" => "erro", "msg" => "Problema interno do sistema. Por favor, tente mais tarde!"];
		else if(!isset($dados['cpf']))
			return ["tipo" => "erro", "msg" => "Campos obrigatórios ainda não foram preenchidos.", "campo" => "cpf"];
		else if($this->buscaPessoa($dados['cpf']))
			return ["tipo" => "erro", "msg" => "CPF já registrado no sistema.", "campo" => "cpf"];

		try{
			$sql = "INSERT INTO pessoa (pessoa_id, pessoa_cpf) 
			values (".$this->db->escape($dados['idUsuario']).", ".$this->db->escape($dados['cpf']).")";

			if(!$query = $this->db->query($sql)){
				if($error = $this->db->error())
					return ["tipo" => "erro", "msg" => "Ocorreu um problema na hora de cadastrar o usuário. Por favor, mude os dados inseridos ou tente mais tarde. Código: ".$error["code"]];
			}else return true;
			
		}catch(Exception $E){
			return ["tipo" => "erro", "msg" => "Problema interno do sistema. Por favor, tente mais tarde!"];
		}
	}

	/**
	 * Altera o cpf de uma pessoa no Banco de Dados
	 * @param 	$idPessoa	ID da pessoa a ser alterada
	 * @param  	$novoCpf 	Novo CPF (duh)
	 * @return 				Boolean indicando o sucesso da alteração ou array com mensagem de erro
	 *	Array format:
	 *		array(
	 *			"Error" => ""
	 *		)
	 */
	public function alteraPessoa($idPessoa, $novoCpf){
		if(!isset($idInst) || !isset($novoCpf)){
			return array("Error" => "Insuficient information to execute the query");
		}

		try{

			$sql = "UPDATE pessoa SET pessoa_cpf = ".$this->db->escape($novoCpf)." 
			WHERE pessoa_id = ".$this->db->escape($idPessoa);

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
	 * Busca no Banco de Dados o cpf de uma pessoa e o retorna
	 * @param 	$idPessoa	ID da pessoa a ser buscada
	 * @return 				Array com o dado buscado da pessoa ou mensagem de erro
	 *	Array format:
	 *		array(
	 *			"cpf" => ""
	 *		)
	 *	Ou:
	 *		array(
	 *			"Error" => ""
	 *		)
	 */
	public function selecionaPessoa($idPessoa){
		if(!isset($idPessoa))
			return ["tipo" => "erro", "msg" => "Problema interno do sistema. Por favor, tente mais tarde!"];

		try{
			$sql = "SELECT pessoa_cpf FROM pessoa
			WHERE pessoa_id = ".$this->db->escape($idPessoa);

			if(!$query = $this->db->query($sql)){
				if($this->db->error()){
					return array("Error" => "$error[message]");
				}
			}else{
				return true;
			}
			
		} catch(Exception $E) {
			return array("Error" => "Server was unable to execute query");
		}
	}

	public function buscaPessoa($cpf){
		if(!isset($cpf))
			return ["tipo" => "erro", "msg" => "Problema interno do sistema. Por favor, tente mais tarde!"];

		try{
			$sql = "SELECT pessoa_cpf FROM pessoa
			WHERE pessoa_cpf = ".$this->db->escape($cpf);

			if(!$query = $this->db->query($sql)){
				if($error = $this->db->error()){
					return ["tipo" => "erro", "msg" => "Ocorreu um problema ao tentar buscar a pessoa. Por favor, tente mais tarde! Código: ".$error["code"]];
				}
			}else{
				if(!count($query->result()))
					return false;

				return true;
			}
			
		}catch(Exception $E){
			return ["tipo" => "erro", "msg" => "Problema interno do sistema. Por favor, tente mais tarde!"];
		}
	}

}