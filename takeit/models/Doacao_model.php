<?php defined('BASEPATH') OR exit('OPSSS... Não é permitido direto acesso ao script!!');

class Doacao_model extends CI_Model {

        public function __construct() {
                parent::__construct();

                $this->load->database();
        }

		/**
		* Insere no Banco de Dados uma doacao
		* @param  $dados 	Array com os dados necessários para a realização da inserção
		*	Array format:
		*		array(
		*			"quantidade" => "",
		*			"interesse_id" => "",
		*			"agradecimento" => ""
		*		)
		* @return 			Boolean indicando o sucesso da inserção ou array com mensagem de erro
		*	Array format:
		*		array(
		*			"Error" => ""
		*		)
		*/
		public function registraDoacao($dados){
			if(!isset($dados['quantidade']) || !isset($dados['interesse_id']) || !isset($dados['agradecimento'])){
				return array("Error" => "Insuficient information to execute the query");
			}

			try{

				$sql = "INSERT INTO doacao (doacao_qtde, doacao_data, interesse_id, doacao_agradecimento) 
				values (".$dados['quantidade'].", ".date('Y/m/d').", ".$dados['interesse_id'].", ".$dados['agradecimento'].")";

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
		* Altera o agradecimento de uma doacao no Banco de Dados
		* @param 	$idDoacao	ID da doacao a ser alterada
		* @param  	$novoAgra 	Novo agradecimento
		* @return 				Boolean indicando o sucesso da alteração ou array com mensagem de erro
		*	Array format:
		*		array(
		*			"Error" => ""
		*		)
		*/
		public function alteraAgradecimento($idDoacao, $novoAgra){
			if(!isset($idDoacao) || !isset($novoAgra)){
				return array("Error" => "Insuficient information to execute the query");
			}

			try{

				$sql = "UPDATE doacao SET doacao_agradecimento = ".$novoAgra." 
				WHERE doacao_id = ".$idDoacao;

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
		* Busca no Banco de Dados os dados de uma doação realizada e os retorna
		* @param 	$idDoacao	ID da doação a ser buscada
		* @return 				Array com os dados buscados da doação ou mensagem de erro
		*	Array format:
		*		array(
		*			"doacao_qtde" => "",
		*			"doacao_data" => "",
		*			"interesse_id" => "",
		*			"doacao_agradecimento" => ""
		*		)
		*	Ou:
		*		array(
		*			"Error" => ""
		*		)
		*/
		public function buscaDoacao($idDoacao){
			if(!isset($idDoacao)){
				return array("Error" => "Insuficient information to execute the query");
			}

			try{

				$sql = "SELECT doacao_qtde, doacao_data, interesse_id, doacao_agradecimento FROM doacao
				WHERE doacao_id = ".$idDoacao;

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
		* Busca no Banco de Dados as doações e as retorna
		* @return 				Array com os dados buscados das doações ou mensagem de erro
		*	Array format:
		*		array(
		*			array(
		*				"doacao_id" => "",
		*				"doacao_qtde" => "",
		*				"doacao_data" => "",
		*				"interesse_id" => ""
		*			),
		*			...
		*		)
		*	Ou:
		*		array(
		*			"Error" => ""
		*		)
		*/
        public function buscaDoacoes(){
        	
			try{

				$sql = "SELECT DISTINCT doacao_id, doacao_qtde, doacao_data, interesse_id FROM doacao";

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

}