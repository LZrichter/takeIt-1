<?php defined('BASEPATH') OR exit('OPSSS... Não é permitido direto acesso ao script!!');

class Usuario_model extends CI_Model{

	protected $senha = "";
	protected $senhaAddOn = "$2a$10$";
	
	private $id = "";
	private $nivel = "";
	private $obrigatorio = [
		"nome", "email", "senha", 
		"confirmacao", "estado", "cidade", 
		"termos"
	];

	public $nome = "";
	public $email = "";
	public $endereco = "";
	public $bairro = "";
	public $numero = "";
	public $complemento = "";
	public $telefone = "";
	public $ativo = "";
	public $cidade_id = "";
	public $cidade_nome = "";
	public $estado_id = "";
	public $estado_uf = "";
	public $nivelUsuario = "";

	function __construct(){
		parent::__construct();

		$this->load->database();
		$this->db->trans_start(TRUE);
	}

	function __destruct(){
		if($this->db->trans_status() === FALSE)
        	$this->db->trans_rollback();
		else
        	$this->db->trans_commit();
	}

	/**
	 * Insere um novo usuário no banco
	 * @param  array $dados Array com os dados a serem inseridos
	 * @return int        	ID do usuário inserido ou false caso ocorra um erro
	 */
	public function insereUsuario(array $dados){
		if(!isset($dados)) 
			return ["tipo" => "erro", "msg" => "Dados não informado"];

		foreach($this->obrigatorio as $campo){
			if(!in_array($campo, array_keys($dados)) || (isset($dados[$campo]) && empty(trim($dados[$campo]))))
				return ["tipo" => "erro", "msg" => "Campos obrigatórios ainda não foram preenchidos.", "campo" => $campo];
		}

		if($dados["senha"] != $dados["confirmacao"]) 
			return ["tipo" => "erro", "msg" => "Confirmação da senha esta incorreta!", "campo" => "confirmacao"];
		else if(self::buscaUsuario(["email" => $dados["email"]]))
			return ["tipo" => "erro", "msg" => "Email já cadastrado.", "campo" => "email"];

		try{
			$this->load->helper("passBCrypt");
			$this->pass = new Bcrypt;

			$sql = "
				INSERT INTO usuario (
					usuario_nome, usuario_email, usuario_senha, 
					usuario_endereco, usuario_bairro, usuario_numero, 
					usuario_complemento, usuario_telefone, usuario_ativo, 
					usuario_nivel, cidade_id
				) VALUES (
					".$this->db->escape($dados["nome"]).", 
					".$this->db->escape($dados["email"]).", 
					".str_replace($this->senhaAddOn, "", $this->db->escape($this->pass->hash($dados["senha"]))).", 
					".$this->db->escape($dados["endereco"]).", 
					".$this->db->escape($dados["bairro"]).", 
					".$this->db->escape($dados["numero"]).", 
					".$this->db->escape($dados["complemento"]).", 
					".$this->db->escape($dados["telefone"]).", 1, 
					".$this->db->escape($dados["tipo_usuario"]).",
					".$this->db->escape($dados["cidade"])."
				)";

			if(!$query = $this->db->query($sql)){
				if($error = $this->db->error()) 
					return ["tipo" => "erro", "msg" => "Não foi possivel inserir o usuário"];
			}else{
				$query = $this->db->query("select last_insert_id() as id");
				self::selecionaUsuario($query->result()[0]->id);

				return ["tipo" => "sucesso", "msg" => "Cadastro efetuado com sucesso."];
			}
		}catch(PDOException $PDOE){
			return ["tipo" => "erro", "msg" => "Problema ao processar os dados no sistema. - Código: " . $PDOE->getCode()];
		}catch(Exception $NE){
			return ["tipo" => "erro", "msg" => "Problema ao executar a tarefa no sistema. - Código: " . $NE->getCode()];
		}

		return ["tipo" => "erro", "msg" => "Problema inesperado no sistema. Tente novamente mais tarde!"];
	}

	/**
	 * Exclui um usuário com seu id
	 * @param  int    	$id ID do usuário a ser removido
	 * @return boolean 		true se exclusão concluida, false se ocorreu erro
	 */
	public function excluiUsuario(int $id){
		if(!isset($id)) 
			return ["tipo" => "erro", "msg" => "Dados não informado"];

		if(!self::selecionaUsuario($id))
			return true;

		try{
			$sql = "DELETE FROM usuario WHERE usuario_id = '$id'";

			if(!$query = $this->db->query($sql)){
				if($error = $this->db->error()) 
					return ["tipo" => "erro", "msg" => "Não foi possivel excluir o usuário."];
			}else return true;
		}catch(PDOException $PDOE){
			return ["tipo" => "erro", "msg" => "Problema ao processar os dados no sistema. - Código: " . $PDOE->getCode()];
		}catch(Exception $NE){
			return ["tipo" => "erro", "msg" => "Problema ao executar a tarefa no sistema. - Código: " . $NE->getCode()];
		}

		return ["tipo" => "erro", "msg" => "Problema inesperado no sistema. Tente novamente mais tarde!"];
	}

	/**
	 * Seleciona um usuário através de seu ID e armazena no objeto
	 * @param  int     $id           ID do usuário a ser buscado
	 * @param  boolean $return_array Campo não obrigatório, true se deseja que seja retornado o array com os dados 
	 * @return boolean/array         True se usuário foi encontrado, false se não ou erro, ou retorna o array com os dados do usuário
	 */
	public function selecionaUsuario(int $id, bool $return_array = false){
		if(!isset($id) or empty(trim($id)))
			return ["tipo" => "erro", "msg" => "ID não informado para a busca."];

		try{
			$sql = "
				SELECT * 
				FROM usuario u NATURAL LEFT JOIN cidade c NATURAL LEFT JOIN estado e
				WHERE usuario_id = $id
			";

			if(!$query = $this->db->query($sql))
				return ["tipo" => "erro", "msg" => "Não foi possivel selecionar o usuário"];
			else{
				if(!count($query->result())) 
					return false;

				if(isset($return_array) and $return_array == TRUE){
					foreach($query->result()[0] as $campo => $valor){
						$campo = str_replace("usuario_", "", $campo);
						$dados[$campo] = $this->$campo = $valor;
					}

					return $dados;
				}else{
					foreach($query->result()[0] as $campo => $valor){
						$campo = str_replace("usuario_", "", $campo);
						$this->$campo = $valor;
					}

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
	 * Busca um usuário através de vários campos apresentados, transformando o objeto no usuário
	 * @param  array  $campos 			Campos a serem buscados com seus valores
	 *                         			Ex: array('nome' => 'Juca', 'email' => 'email@host.com')
	 * @param  boolean $return_array 	Campo não obrigatório, true se deseja que seja retornado o array com os dados 
	 * @return boolean/array   			true se encontrado, false se não encontrado ou erro, ou array com os dados
	 */
	public function buscaUsuario(array $campos, bool $return_array = false){
		if(!isset($campos) || !is_array($campos) || empty($campos))
			return ["tipo" => "erro", "msg" => "Campos não informados."];

		try{
			$pesquisa = "";
			$count = 0;
			foreach($campos as $nome => $valor){
				$count++;

				if(strpos($nome, "cidade_") !== false || strpos($nome, "estado_") !== false){
					if($count == count($campos)) 
						$pesquisa .= $nome . " = " . $this->db->escape($valor);	
					else 
						$pesquisa .= $nome . " = " . $this->db->escape($valor) . " AND ";
				}else{
					if($count == count($campos)) 
						$pesquisa .= "usuario_" . $nome . " = " . $this->db->escape($valor);	
					else 
						$pesquisa .= "usuario_" . $nome . " = " . $this->db->escape($valor) . " AND ";
				}
			}

			$sql = "
				SELECT * 
				FROM usuario u NATURAL LEFT JOIN cidade c NATURAL LEFT JOIN estado e
				WHERE $pesquisa
			";

			if(!$query = $this->db->query($sql)){
				if($error = $this->db->error()) 
					return ["tipo" => "erro", "msg" => "Não foi possivel inserir o usuário"];
			}else{
				if(!count($query->result())) 
					return false;

				if(isset($return_array) and $return_array == true){
					foreach($query->result()[0] as $campo => $valor){
						$campo = str_replace("usuario_", "", $campo);
						$dados[$campo] = $this->$campo = $valor;
					}

					return $dados;
				}else{
					foreach($query->result()[0] as $campo => $valor){
						$campo = str_replace("usuario_", "", $campo);
						if($campo == "nivel") 
							$this->nivelUsuario = $valor;
						$this->$campo = $valor;
					}
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

	public function getId(){
		return $this->id;
	}

	public function testaSenha($senha){
		$this->load->helper("passBCrypt");
		$this->pass = new Bcrypt;

		return $this->pass->check($senha, $this->senhaAddOn.$this->senha);
	}

} ?>