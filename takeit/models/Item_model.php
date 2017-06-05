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
		* @param  $dados 	Array com os dados necessários para a realização da inserção
		*	Array format:
		*		array(
		*			"descricao" => "",
		*			"quantidade" => "",
		*			"idUsuario" => "",
		*			"idCategoria" => ""
		*		)
		* @return 					Boolean indicando o sucesso da alteração ou array com mensagem de erro
		*	Array format:
		*		array(
		*			"Error" => ""
		*		)
		*/
		public function alteraItem($dados){
			if(!isset($dados['idItem']) || !isset($dados['descricao']) || !isset($dados['quantidade']) || !isset($dados['idCategoria']) || !isset($dados['detalhes'])){
				return array("tipo" => "erro", "msg" => "Informação insufiiente para executar a consulta.");
			}

			try{

				$sql = "UPDATE item SET item_descricao = ".$this->db->escape($dados['descricao']).", item_qtde = ".$this->db->escape($dados['quantidade']).", categoria_id = ".$this->db->escape($dados['idCategoria']).", item_detalhes =".$this->db->escape($dados['detalhes'])." WHERE item_id = ".$this->db->escape($dados['idItem']);

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
		* Busca no Banco de Dados a os dados de um item COM APENAS UMA FOTO DO MESMO com base no id do usuario e os retorna.
		* @param  $idUsuario -> ID do usuario a ser buscada
		* @param  $status -> Status do item ou Array com vários estados, se não setado busca em todos status
		* @return Array com os dados buscados do item ou mensagem de erro
		*	Array format:
		*		array(
		*			"item_descricao" => "",
		*			"item_qtde" => "",
		*			"item_data" => "",
		*			"item_status" => "",
		*			"usuario_id" => "",
		*			"categoria_id" => "",
		*			"imagem_caminho" => "",
		*			"imagem_nome" => "",
		*		)
		*	Ou:
		*		array(
		*			"tipo" => "erro", "msg" => ""
		*		)
		*/
		public function buscaItemUsuario($idUsuario, $status = NULL){		

			if(!isset($idUsuario)){
				return array( "tipo" => "erro", "msg" => "Informação insuficiente para executar a consulta.");
			}elseif ( $status == NULL ) { //retorna item com qualquer status
				$sql ="
					SELECT item_id, item_descricao, item_qtde, item_data, item_status, usuario_id, categoria_id, 
					(SELECT imagem_caminho FROM imagem WHERE imagem.item_id = i.item_id LIMIT 1) AS imagem_caminho , 
					(SELECT imagem_nome FROM imagem WHERE imagem.item_id = i.item_id LIMIT 1) AS imagem_nome 
					FROM item i
					WHERE usuario_id = ".$idUsuario." ORDER BY item_data DESC";
			}else{ //retorna item com status especifico

				$sql ="
						SELECT item_id, item_descricao, item_qtde, item_data, item_status, usuario_id, categoria_id, 
						(SELECT imagem_caminho FROM imagem WHERE imagem.item_id = i.item_id LIMIT 1) AS imagem_caminho , 
						(SELECT imagem_nome FROM imagem WHERE imagem.item_id = i.item_id LIMIT 1) AS imagem_nome 
						FROM item i
						WHERE usuario_id = ".$idUsuario;

				if ( is_array($status)){
					$sql .= ' AND item_status=';
					foreach ($status as $key => $value){
						if( $key == count($status)-1 )
							$sql .= $this->db->escape($value);	
						else
							$sql .= $this->db->escape($value)." OR item_status=";
					}
				}else{
					$sql .= " AND item_status=".$this->db->escape($status);
				}

				$sql .= " ORDER BY item_data DESC";
			}

			$result = array();

			try{

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
        public function buscaItemCidade($idCidade){
        	
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


        /**
		* Busca no Banco de Dados os dados de um item com base no id do mesmo e os retorna.
		* @param  $idItem -> ID do item a ser buscada
		* @return Array com os dados buscados do item ou mensagem de erro
		*	Array format:
		*		array(
		*			"item_descricao" => "",
		*			"item_qtde" => "",
		*			"item_data" => "",
		*			"item_status" => "",
		*			"usuario_id" => "",
		*			"categoria_id" => "",
		*		)
		*	Ou:
		*		array(
		*			"tipo" => "erro", "msg" => ""
		*		)
		*/
        public function buscaItemPorId($idItem){
        	try{
				$sql =" SELECT * from item where item_id =".$idItem;

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

			}catch(Exception $E) {
				return array("tipo" => "erro", "msg" => "Erro inexperado ao realizar a consulta, por favor tenta mais tarde!!!");
			}
        }


        /**
         * Descrição: Altera o status do item passado como parâmetro
         * 
         * @param  $idItem -> Id do item a ser alterado o status
         * @param $status -> novo status do item
         * @return  Boolean de confirmação
         */
        public function alteraStatusItemPorId($idItem, $status){

        	if(!isset($idItem) || !isset($status)){
        		return array( "tipo" => "erro", "msg" => "Informação insuficiente para executar a consulta.");
        	}
        	$aceitos = ["Disponível", 1, "Solicitado", 2, "Doado", 3, "Cancelado", 4];

        	if( in_array($status, $aceitos) ){
        		$sql = " UPDATE item SET item_status =".$this->db->escape($status)." WHERE item_id =".$this->db->escape($idItem);

	        	try{

					if(!$query = $this->db->query($sql)){
						if($this->db->error()){
							return array("tipo" => "erro", "msg" => $this->db->_error_message());
						}
					}else {
						return true;
					}

				}catch(Exception $E){
					return array("tipo" => "erro", "msg" => "Erro inexperado ao realizar a consulta, por favor tenta mais tarde!!!");
				}
        	}else{
        		return false;
        	}

        }

}