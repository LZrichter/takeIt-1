<?php defined('BASEPATH') OR exit('OPSSS... Não é permitido direto acesso ao script!!');

class Instituicao_model extends CI_Model {

    public function __construct() {
        parent::__construct();

        $this->load->database();
    }

	/**
	 * Insere uma instituição no banco de dados
	 * @param  array $dados  Array com todos os dados da instituição vindo do formulário de cadastro
	 * @return array         Array com a resposta caso tenha dado erro ou não
	 */
	public function insereInstituicao($dados){
		$this->db->trans_begin();
		$this->load->helper("validacao");

		$resposta = $this->usuario->insereUsuario($dados);

		if($resposta["tipo"] == "sucesso"){
			if(!isset($dados['cnpj'])){
				$this->db->trans_rollback();
				return ["tipo" => "erro", "msg" => "Campos obrigatórios ainda não foram preenchidos.", "campo" => "cnpj"];
			}else if(!validaCNPJ($dados['cnpj'])){
				$this->db->trans_rollback();
				return ["tipo" => "erro", "msg" => "CNPJ informado não é válido.", "campo" => "cnpj"];
			}else if($this->buscaInstituicao($dados['cnpj'])){
				$this->db->trans_rollback();
				return ["tipo" => "erro", "msg" => "CNPJ já registrado no sistema.", "campo" => "cnpj"];
			}

			try{
				$sql = "INSERT INTO instituicao (instituicao_id, instituicao_cnpj, instituicao_site) 
				values (".$this->db->escape($this->usuario->getId()).", ".$this->db->escape($dados['cnpj']).", ".$this->db->escape($dados['website']).")";

				if(!$query = $this->db->query($sql)){
					if($this->db->error()){
						$this->db->trans_rollback();
						return ["tipo" => "erro", "msg" => "Ocorreu um problema na hora de cadastrar a Instituição. Por favor, mude os dados inseridos ou tente mais tarde. Código: ".$error["code"]];
					}else{
						$this->db->trans_rollback();
						return ["tipo" => "erro", "msg" => "Ocorreu um problema na hora de cadastrar a Instituição. Por favor, mude os dados inseridos ou tente mais tarde."];
					}
				}else{
        			$this->db->trans_commit();
					return ["tipo" => "sucesso", "msg" => "Cadastro efetuado com sucesso."];
				}
				
			}catch(PDOException $PDOE){
				$this->db->trans_rollback();
				return ["tipo" => "erro", "msg" => "Problema ao processar os dados no sistema. - Código: " . $PDOE->getCode()];
			}catch(Exception $E){
				$this->db->trans_rollback();
				return ["tipo" => "erro", "msg" => "Problema interno do sistema. Por favor, tente mais tarde!"];
			}
		}else{
			$this->db->trans_rollback();
			return $resposta;	
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
	public function selecionaInstituicao($idInst){
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

	public function todasInstituicoes(){
		try{
			$sql = "SELECT DISTINCT usuario_id, usuario_nome, cidade_nome, estado_uf
 				FROM estado NATURAL JOIN cidade NATURAL JOIN usuario";

 			if(!$query = $this->db->query($sql)){
				if($this->db->error()){
					return array("Error" => "$error[message]");
				}
			}else if(!count($query->result()))
				return array("tipo" => "erro", "msg" => "Nenhuma instituição cadastrada no momento.");
			else{
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
			return ["tipo" => "erro", "msg" => "Problema ao processar os dados no sistema. Por favor, tente mais tarde! - Código: " . $PDOE->getCode()];
		}catch(Exception $E){
			return ["tipo" => "erro", "msg" => "Problema interno do sistema. Por favor, tente mais tarde! - Código: " . $E->getCode()];
  		}
	}

	
	/**
	 * Busca uma instituição pelo seu cnpj (Mais usado na hora de cadastrar, para ver se o cpf já existe no sistema)
	 * @param  string $cnpj CNPJ a ser buscado
	 * @return boolean       TRUE se já existe uma instituição cadastrada no sistema com esse CNPJ, FALSE se não.
	 */
    public function buscaInstituicao($cnpj){
		if(!isset($cnpj))
			return ["tipo" => "erro", "msg" => "Problema interno do sistema. Por favor, tente mais tarde!"];

		try{
			$sql = "SELECT instituicao_cnpj FROM instituicao
			WHERE instituicao_cnpj = ".$this->db->escape($cnpj);

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