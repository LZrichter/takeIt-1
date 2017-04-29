<?php defined('BASEPATH') OR exit('OPSSS... Não é permitido direto acesso ao script!!');

class Usuario_model extends CI_Model{

	protected $senha = "";
	
	private $id = "";
	private $nivel = "";

	// NÃO SEI SE VAMOS FAZER ASSIM CARA, É MUITA COISA E PARECE SPAM
	// SPAM SPAM SPAM
	// SPAM SPAM SPAM SPAM SPAM

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
	public $estado_nome = "";

	private $obrigatorio = ['nome','email','senha','cidade_nome','estado_nome'];

	function __construct(){
		parent::__construct();

		$this->load->database();
		$this->load->helper('erro');
		$this->erro = new Erro();
	}

	/**
	 * Insere um novo usuário no banco
	 * @param  array $dados Array com os dados a serem inseridos
	 * @return int        	ID do usuário inserido ou false caso ocorra um erro
	 */
	public function insereUsuario(array $dados){
		
	}

	/**
	 * Exclui um usuário com seu id
	 * @param  int    	$id ID do usuário a ser removido
	 * @return boolean 		true se exclusão concluida, false se ocorreu erro
	 */
	public function excluiUsuario(int $id){

	}

	/**
	 * Seleciona um usuário através de seu ID e armazena no objeto
	 * @param  int     $id           ID do usuário a ser buscado
	 * @param  boolean $return_array Campo não obrigatório, true se deseja que seja retornado o array com os dados 
	 * @return boolean/array         True se usuário foi encontrado, false se não ou erro, ou retorna o array com os dados do usuário
	 */
	public function selecionaUsuario(int $id, bool $return_array = FALSE){
		if(!isset($id) or empty($id)){
			$this->erro("sys", "ID não informado.");

			return FALSE;
		}

		try{
			if(!$query = $this->db->query("
				SELECT * 
				FROM usuario u NATURAL LEFT JOIN cidade c NATURAL LEFT JOIN estado e
				WHERE usuario_id = $id
			")){
				if($error = $this->db->error()){
					$this->erro("sql", "Ocorreu um erro na tentativa de selecionar um usuário: $error[code] - $error[message]");

					return FALSE;
				}
			}else{
				if(isset($return_array) and $return_array == TRUE){
					foreach($query->result()[0] as $campo => $valor){
						$campo = str_replace("usuario_", "", $campo);
						$dados[$campo] = $this->$campo = $valor;
					}

					return $dados;
				}else{
					foreach($query->result() as $campo => $valor){
						$campo = str_replace("usuario_", "", $campo);
						$this->$campo = $valor;

						return TRUE;
					}
				}
			}
		}catch(PDOException $PDOE){
			$this->erro("pdo", "Excessão: " . $PDOE->getCode() . " - " . $PDOE->getMessage());
			return FALSE;
		}catch(Exception $NE){
			$this->erro("sys", "Excessão: " . $NE->getCode() . " - " . $NE->getMessage());
			return FALSE;
		}

		$this->erro("sys", "Erro inesperado.");
		return FALSE;
	}


	/**
	 * Busca um usuário através de vários campos apresentados, transformando o objeto no usuário
	 * @param  array  $campos 			Campos a serem buscados com seus valores
	 *                         			Ex: array('nome' => 'Juca', 'email' => 'email@host.com')
	 * @param  boolean $return_array 	Campo não obrigatório, true se deseja que seja retornado o array com os dados 
	 * @return boolean/array   			true se encontrado, false se não encontrado ou erro, ou array com os dados
	 */
	public function buscaUsuario(array $campos, bool $return_array = false){

	}

	/**
	 * Retorna o tipo de usuário selecionado na instância
	 * @return string tipo do usuário (Pessoa, Instituição ou Admin)
	 */
	public function tipoUsuario(){

	}

} ?>