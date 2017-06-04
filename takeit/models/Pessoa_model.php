<?php defined('BASEPATH') OR exit('OPSSS... Não é permitido direto acesso ao script!!');

class Pessoa_model extends Usuario_model{

    public function __construct(){
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
	public function inserePessoa(array $dados){
		$this->db->trans_begin();
		$this->load->helper("validacao");

		if(!isset($dados['cpf']))
			return ["tipo" => "erro", "msg" => "Campos obrigatórios ainda não foram preenchidos.", "campo" => "cpf"];
		else if(!validaCPF($dados['cpf']))
			return ["tipo" => "erro", "msg" => "CPF informado não é válido.", "campo" => "cpf"];
		else if($this->buscaPessoa($dados['cpf']))
			return ["tipo" => "erro", "msg" => "CPF já registrado no sistema.", "campo" => "cpf"];

		$resposta = $this->insereUsuario($dados);

		if($resposta["tipo"] == "sucesso"){
			try{
				$sql = "INSERT INTO pessoa (pessoa_id, pessoa_cpf) 
				values (".$this->db->escape($this->getId()).", ".$this->db->escape($dados['cpf']).")";

				if(!$query = $this->db->query($sql)){
					if($this->usuario->excluiUsuario($this->getId()) !== true)
						return ["tipo" => "erro", "msg" => "Ocorreu um problema na hora de cadastrar a Pessoa. Por favor, mude os dados inseridos ou tente mais tarde."];

					if($error = $this->db->error()){
						$this->db->trans_rollback();
						return ["tipo" => "erro", "msg" => "Ocorreu um problema na hora de cadastrar a Pessoa. Por favor, mude os dados inseridos ou tente mais tarde. Código: ".$error["code"]];
					}
				}else{
        			$this->db->trans_commit();
					return ["tipo" => "sucesso", "msg" => "Cadastro efetuado com sucesso."];
				}
				
			}catch(PDOException $PDOE){
				return ["tipo" => "erro", "msg" => "Problema ao processar os dados no sistema. - Código: " . $PDOE->getCode()];
			}catch(Exception $E){
				return ["tipo" => "erro", "msg" => "Problema interno do sistema. Por favor, tente mais tarde!"];
			}
		}else{
			$this->db->trans_rollback();
			return $resposta;
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
	 * Busca no banco a Pessoa a partir de seu ID
	 * @param  int          $idPessoa  	  ID da pessoa a ser buscada
	 * @param  bool|boolean $return_array Se deseja que os dados sejam retornados em forma de array
	 * @return bool|array                 Se $returns for true, retorna um array com todos os dados, se não retorna true se a pessoa foi selecionada	
	 */
	public function selecionaPessoa($idPessoa, bool $return_array = false){
		if(!isset($idPessoa) || empty(trim($idPessoa)))
			return ["tipo" => "erro", "msg" => "ID não informado para a busca."];

		$resposta = $this->selecionaUsuario($idPessoa, $return_array);

		if($return_array && isset($resposta["tipo"]) && $resposta["tipo"] == "erro")
			return ["tipo" => "erro", "msg" => "Não foi possivel selecionar a pessoa. Por favor, tente mais tarde!"];
		else if(!$return_array && $resposta !== true)
			return ["tipo" => "erro", "msg" => "Não foi possivel selecionar a pessoa. Por favor, tente mais tarde!"];

		try{
			$sql = "SELECT pessoa_cpf FROM pessoa
			WHERE pessoa_id = ".$this->db->escape($idPessoa);

			if(!$query = $this->db->query($sql)){
				if($this->db->error())
					return ["tipo" => "erro", "msg" => "Não foi possivel selecionar a pessoa. Por favor, tente mais tarde!"];
			}else{
				if(!count($query->result()))
					return false;

				if($return_array === true){
					foreach($query->result()[0] as $campo => $valor)
						$dados[$campo] = $this->$campo = $valor;

					$dados = array_merge($dados, $resposta);

					return $dados;
				}else{
					foreach($query->result()[0] as $campo => $valor)
						$this->$campo = $valor;

					return true;
				}
			}			
		}catch(PDOException $PDOE){
			return ["tipo" => "erro", "msg" => "Problema ao processar os dados no sistema. - Código: " . $PDOE->getCode()];
		}catch(Exception $NE){
			return ["tipo" => "erro", "msg" => "Problema ao executar a tarefa no sistema. - Código: " . $NE->getCode()];
		}

		return ["tipo" => "erro", "msg" => "Problema inesperado no sistema. Tente novamente mais tarde!"];
	}

	/**
	 * Busca uma pessoa pelo seu cpf (Mais usado na hora de cadastrar, para ver se o cpf já existe no sistema)
	 * @param  string $cpf  CPF a ser buscado
	 * @return boolean      TRUE se já existe uma pessoa cadastrada no sistema com esse CPF, FALSE se não.
	 */
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