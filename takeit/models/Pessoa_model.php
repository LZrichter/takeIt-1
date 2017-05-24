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
			if(!isset($dados['idUsuario']) || !isset($dados['cpf'])){
				return array("Error" => "Insuficient information to execute the query");
			}

			try{

				$sql = "INSERT INTO pessoa (pessoa_id, pessoa_cpf) 
				values (".$dados['idUsuario'].", ".$dados['cpf'].")";

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

				$sql = "UPDATE pessoa SET pessoa_cpf = ".$novoCpf." 
				WHERE pessoa_id = ".$idPessoa;

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