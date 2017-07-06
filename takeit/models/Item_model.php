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
		* Busca A quantidade total de item filtrada por status ou não
		* @param  $status -> Status do item ou Array com vários estados, se não setado busca em todos status
		* @return Array com os dados dos itens ou mensagem de erro
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
		public function buscaQtdeItens($status = NULL){		

			if ( $status == NULL ) { //retorna item com qualquer status
				$sql ="SELECT * from item";
			}else{ //retorna item com status especifico

				$sql ="SELECT * from item WHERE";

				if ( is_array($status)){
					$sql .= ' item_status=';
					foreach ($status as $key => $value){
						if( $key == count($status)-1 )
							$sql .= $this->db->escape($value);	
						else
							$sql .= $this->db->escape($value)." OR item_status=";
					}
				}else{
					$sql .= " item_status=".$this->db->escape($status);
				}	
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
		* Busca no Banco de Dados os dados de um item COM APENAS UMA FOTO DO MESMO com base no id do usuario e os retorna.
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
					$sql .= ' AND ( item_status=';
					foreach ($status as $key => $value){
						if( $key == count($status)-1 )
							$sql .= $this->db->escape($value);	
						else
							$sql .= $this->db->escape($value)." OR item_status=";
					}
					$sql .= ")";
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
		* Busca no Banco de Dados N itens disponíveis ou em negociação a partir de um índice e os retorna
		* @param 	Array com os dados necessários para realizar a busca
		*	Array format:
		*		array(
		*			"indice" => "",
		*			"cidade_id" => "",
		*			"categoria_id" => "",		//enviar 0 caso o usuário não tenha filtrado uma categoria
		*			"busca" => "",				//enviar string vazia caso o usuário não tenha feito uma busca
		*			"usuario_id" => ""
		*		)
		* @return 	Array com os dados buscados dos itens ou mensagem de erro
		*	Array format:
		*		array(
		*			"paginas_qtde" => "",
		*			array(
		*				"item_descricao" => "",
		*				"item_qtde" => "",
		*				"imagem_caminho" => "",
		*				"imagem_nome" => "",
		*				"interessado" => "",
		*			),
		*			...
		*		)
		*	Ou:
		*		array(
		*			"tipo" => "erro", "msg" => ""
		*		)
		*/
        public function buscaItensCidade($dados){

        	if(!isset($dados["indice"]) || !isset($dados["cidade_id"]) || !isset($dados["categoria_id"]) || 
        		!isset($dados["busca"]) || !isset($dados["usuario_id"])){
				return array( "tipo" => "erro", "msg" => "Informação insuficiente para executar a consulta.");
			} else {
				$limite = 30;
				$sql = "SELECT item_id, item_descricao, item_qtde, (SELECT imagem_caminho FROM imagem WHERE imagem.item_id = i.item_id LIMIT 1) AS imagem_caminho, (SELECT imagem_nome FROM imagem WHERE imagem.item_id = i.item_id LIMIT 1) AS imagem_nome, (SELECT count(*) FROM interesse WHERE interesse.item_id = i.item_id and interesse.usuario_id = ".$dados['usuario_id'].") as interessado FROM usuario u NATURAL JOIN item i WHERE cidade_id = ".$dados['cidade_id']." AND (item_status = 'Disponível' OR item_status = 'Solicitado') AND item_descricao LIKE '%".$dados['busca']."%' AND u.usuario_id <> ".$dados['usuario_id'];
				if ($dados['categoria_id'] != 0) {
					$sql .= " AND categoria_id = ".$dados['categoria_id'];
				}
				$sql .= " LIMIT ".(($dados['indice']-1)*$limite).", ".$limite;

				$sql2 = "SELECT count(*) as qtde FROM usuario u NATURAL JOIN item i WHERE cidade_id = ".$dados['cidade_id']." AND (item_status = 'Disponível' OR item_status = 'Solicitado') AND item_descricao LIKE '%".$dados['busca']."%' AND u.usuario_id <> ".$dados['usuario_id'];
				if ($dados['categoria_id'] != 0) {
					$sql2 .= " AND categoria_id = ".$dados['categoria_id'];
				}

				try{

					$result = array();

					if(!$query = $this->db->query($sql)){
						if($this->db->error()){
							return array("tipo" => "erro", "msg" => $this->db->_error_message());
						}
					} else {
						$count = 0;
						foreach($query->result() as $row){
							foreach ($row as $campo => $valor) {
								$result[$count][$campo] = $valor;
							}
							$count++;
						}
					}

				}catch(Exception $E){
					return array("tipo" => "erro", "msg" => "Erro inexperado ao realizar a consulta, por favor tente mais tarde!");
				}

				try{
					if(!$query = $this->db->query($sql2)){
						if($this->db->error()){
							return array("tipo" => "erro", "msg" => $this->db->_error_message());
						}
					} else {
						$sum = (($query->result()[0]->qtde % $limite == 0) ? 0 : 1);
						$result["paginas_qtde"] = floor($query->result()[0]->qtde/$limite + $sum);
						return $result;
					}

				}catch(Exception $E){
					return array("tipo" => "erro", "msg" => "Erro inexperado ao realizar a consulta, por favor tenta mais tarde!!!");
				}
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
        	if (!isset($idItem)) {
        		return array("tipo" => "erro", "msg" => "Dados insuficientes para realizar este consulta!!!");
        	}
        	try{
				$sql = " SELECT i.*, 
						(SELECT imagem_caminho FROM imagem WHERE imagem.item_id = i.item_id LIMIT 1) AS imagem_caminho , 
						(SELECT imagem_nome FROM imagem WHERE imagem.item_id = i.item_id LIMIT 1) AS imagem_nome 
						FROM item i WHERE i.item_id =".$idItem;

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


        /**
         * Descrição: Altera o status dos itens de um usuário passado por parametro
         * 
         * @param  $idUser -> Id do usuario a ter o status dos seus itens alterados
         * @param $status -> novo status dos itens
         * @return  Boolean de confirmação
         */
        public function alteraStatusItemPorUsuario($idUser, $status){

        	if(!isset($idUser) || !isset($status)){
        		return array( "tipo" => "erro", "msg" => "Informação insuficiente para executar a consulta.");
        	}
        	$aceitos = ["Disponível", 1, "Solicitado", 2, "Doado", 3, "Cancelado", 4];

        	if( in_array($status, $aceitos) ){
        		$sql = " UPDATE item SET item_status =".$this->db->escape($status)." WHERE usuario_id =".$this->db->escape($idUser);

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