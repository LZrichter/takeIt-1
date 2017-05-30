<?php defined('BASEPATH') OR exit('OPSSS... Não é permitido direto acesso ao script!!');

class Imagem_model extends CI_Model {

    public function __construct() {
        parent::__construct();

        $this->load->database();
    }

	/**
	 * Insere no Banco de Dados uma imagem
	 * OBS: O item deve ser cadastrado antes da imagem por causa das referências no BD
	 * @param  $dados 	Array com os dados necessários para a realização da inserção
	 *	Array format:
	 *		array(
	 *			"imagem_nome" => "",
	 *			"imagem_caminho" => "",
	 *			"imagem_tamanho" => "",
	 *			"item_id" => ""
	 *		)
	 * @return 			Boolean indicando o sucesso da inserção ou array com mensagem de erro
	 *	Array format:
	 *		array(
	 *			"Error" => ""
	 *		)
	 */
	public function insereImagem($dados){
		if(!isset($dados['imagem_nome']) || !isset($dados['imagem_caminho']) || 
			!isset($dados['imagem_tamanho']) || !isset($dados['item_id'])){
			return array("Error" => "Insuficient information to execute the query");
		}

		try{

			$sql = "INSERT INTO imagem (imagem_nome, imagem_caminho, imagem_tamanho, item_id) 
			values (".$dados['imagem_nome'].", ".$dados['imagem_caminho'].", ".
				$dados['imagem_tamanho'].", ".$dados['item_id'].")";

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
	 * Altera o nome, o caminho e o tamanho de uma imagem no Banco de Dados
	 * @param 	$imagem_id			Id da imagem a ser alterada
	 * @param 	$imagem_nome		Novo nome da imagem
	 * @param  	$imagem_caminho 	Novo caminho da imagem
	 * @param  	$imagem_tamanho 	Novo tamanho da imagem
	 * @return 						Boolean indicando o sucesso da alteração ou array com mensagem de erro
	 *	Array format:
	 *		array(
	 *			"Error" => ""
	 *		)
	 */
	public function alteraInstituicao($imagem_id, $imagem_nome, $imagem_caminho, $imagem_tamanho){
		if(!isset($imagem_id) || !isset($imagem_nome) || !isset($imagem_caminho) ||  || !isset($imagem_tamanho)){
			return array("Error" => "Insuficient information to execute the query");
		}

		try{

			$sql = "UPDATE imagem SET imagem_nome = ".$imagem_nome.", imagem_caminho = ".$imagem_caminho.
			", imagem_tamanho = ".$imagem_tamanho."	WHERE imagem_id = ".$imagem_id;

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
	 * Busca no Banco de Dados o nome, o caminho e o tamanho da primeira imagem de um item e os retorna
	 * @param 	$item_id		ID do item cuja imagem será buscada
	 * @return 					Array com os dados buscados da imagem ou mensagem de erro
	 *	Array format:
	 *		array(
	 *			"imagem_nome" => "",
	 *			"imagem_caminho" => "",
	 *			"imagem_tamanho" => ""
	 *		)
	 *	Ou:
	 *		array(
	 *			"Error" => ""
	 *		)
	 */
	public function buscaPrimeiraImagem($item_id){
		if(!isset($item_id)){
			return array("Error" => "Insuficient information to execute the query");
		}

		try{

			$sql = "SELECT imagem_nome, imagem_caminho, imagem_tamanho FROM imagem NATURAL JOIN item
			WHERE item_id = ".$item_id." LIMIT 1";

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
	 * Busca no Banco de Dados as 5 imagens de um item e as retorna
	 * @param 	$item_id		ID do item cujas imagens serão buscadas
	 * @return 				Array com os dados buscados das imagens ou mensagem de erro
	 *	Array format:
	 *		array(
	 *			array(
	 *				"imagem_nome" => "",
	 *				"imagem_caminho" => "",
	 *				"imagem_tamanho" => ""
	 *				"estado_uf" => ""
	 *			),
	 *			...
	 *		)
	 *	Ou:
	 *		array(
	 *			"Error" => ""
	 *		)
	 */
    public function buscaImagens(){
    	
		try{

			$sql = "SELECT DISTINCT imagem_nome, imagem_caminho, imagem_tamanho
			FROM imagem NATURAL JOIN item WHERE item_id = ".$item_id;

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