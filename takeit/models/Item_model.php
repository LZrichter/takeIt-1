<?php defined('BASEPATH') OR exit('OPSSS... Não é permitido direto acesso ao script!!');

class Item_model extends CI_Model {

        public function __construct() {
                parent::__construct();

                $this->load->database();
        }

		/**
		* Insere no Banco de Dados um item
		* @param  $dados 	Array com os dados necessários para a realização da inserção
		*	Array format:
		*		array(
		*			"descricao" => "",
		*			"quantidade" => "",
		*			"idUsuario" => "",
		*			"idCategoria" => ""
		*		)
		* @return 			Id do produto inserido ou array com mensagem de erro
		*	Array format:
		*		array(
		*			"Error" => ""
		*		)
		*/
		public function insereItem($dados){
			if(!isset($dados['descricao']) || !isset($dados['quantidade']) || !isset($dados['detalhes']) || !isset($dados['idUsuario']) || !isset($dados['idCategoria'])){
				return array("tipo" => "erro", "msg" => "Informação insuficiente para executar a consulta.");
			}

			try{
				$sql = "INSERT INTO item (item_descricao, item_qtde, item_detalhes, item_data, item_status, usuario_id, categoria_id) 
				values ("
					.$this->db->escape($dados['descricao']).","
					.$this->db->escape($dados['quantidade']).", "
					.$this->db->escape($dados['detalhes']).", "
					.$this->db->escape(date('Y:m:d')).","
					.$this->db->escape('Disponível').", "
					.$this->db->escape($dados['idUsuario']).", "
					.$this->db->escape($dados['idCategoria']).
				")";

				if(!$query = $this->db->query($sql)){
					if($this->db->error()){
						return array("tipo" => "erro", "msg" => $this->db->_error_message());
					}
				}else{
					$lastId = $this->db->insert_id();
					return array("tipo" => "sucesso", "msg" => "Sucesso ao inserir sua doação.", "idItem" => $lastId);
				}
				
			}catch(Exception $NE) {
				return array("tipo" => "erro", "msg" => "Problema ao executar a tarefa no sistema. - Código: " . $NE->getCode());
			}catch(PDOException $PDOE){
				return array("tipo" => "erro", "msg" => "Problema ao processar os dados no sistema. - Código: " . $PDOE->getCode());
			}
		}

		/**
		* Altera a descrição, quantidade e id da Categoria de um item no Banco de Dados
		* @param 	$idItem			ID do item a ser alterado
		* @param 	$descricao		Descrição do item
		* @param  	$quantidade 	Nova quantidade de itens
		* @param  	$idCategoria 	Nova categoria
		* @return 					Boolean indicando o sucesso da alteração ou array com mensagem de erro
		*	Array format:
		*		array(
		*			"Error" => ""
		*		)
		*/
		public function alteraItem($idItem, $descricao, $quantidade, $idCategoria){
			if(!isset($idItem) || !isset($descricao) || !isset($quantidade) || !isset($idCategoria)){
				return array("Error" => "Insuficient information to execute the query");
			}

			try{

				$sql = "UPDATE item SET item_descricao = ".$descricao.", item_qtde = ".$quantidade."
				, categoria_id = ".$idCategoria." WHERE item_id = ".$idItem;

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
		* Busca no Banco de Dados a descrição, quantidade e id da Categoria de um item e os retorna
		* @param 	$idItem		ID do item a ser buscada
		* @return 				Array com os dados buscados do item ou mensagem de erro
		*	Array format:
		*		array(
		*			"item_descricao" => "",
		*			"item_qtde" => "",
		*			"item_data" => "",
		*			"item_status" => "",
		*			"usuario_id" => "",
		*			"categoria_id" => ""
		*		)
		*	Ou:
		*		array(
		*			"Error" => ""
		*		)
		*/
		public function buscaItem($idItem){
			if(!isset($idItem)){
				return array("Error" => "Insuficient information to execute the query");
			}

			try{

				$sql = "SELECT item_descricao, item_qtde, item_data, item_status, usuario_id, categoria_id FROM item
				WHERE item_id = ".$idItem;

				if(!$query = $this->db->query($sql)){
					if($this->db->error()){
						return array("Error" => "$error[message]");
					}
				} else {
					foreach($query->result() as $row){
						foreach ($row as $campo => $valor) {
							$result[$campo] = $valor;
						}
					}
					return $result;
				}

			} catch(Exception $E) {
				return array("Error" => "Server was unable to execute query");
			}
		}

		/**
		* Busca no Banco de Dados os itens e os retorna
		* @return 				Array com os dados buscados dos itens ou mensagem de erro
		*	Array format:
		*		array(
		*			array(
		*				"NOME DO ITEM (MUDAR DEPOIS)" => ""
		*			),
		*			...
		*		)
		*	Ou:
		*		array(
		*			"Error" => ""
		*		)
		*/
        public function buscaItens($idCidade){
        	
			try{

				$sql = "SELECT DISTINCT item_id, item_descricao, item_qtde, item_data, item_status, usuario_id, categoria_id
				FROM cidade NATURAL JOIN usuario NATURAL JOIN item WHERE cidade_id = ".$idCidade;

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