<?php defined('BASEPATH') OR exit('OPSSS... Não é permitido direto acesso ao script!!');

class Usuario_model extends CI_Model{

	private $obrigatorio = []

	function __construct(){
		parent::__construct();

		$this->load->database();
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
	 * Seleciona um usuário através de seu ID
	 * @param  int     $id           ID do usuário a ser buscado
	 * @param  boolean $return_array Campo não obrigatório, true se deseja que seja retornado o array com os dados 
	 * @return [type]                [description]
	 */
	public function selecionaUsuario(int $id, $return_array = false){

	}

	/**
	 * Busca um usuário através de vários campos apresentados, transformando o objeto no usuário
	 * @param  array  $campos 			Campos a serem buscados com seus valores
	 *                         			Ex: array('nome' => 'Juca', 'email' => 'email@host.com')
	 * @param  boolean $return_array 	Campo não obrigatório, true se deseja que seja retornado o array com os dados 
	 * @return boolean/array   			true se encontrado, false se não encontrado ou erro, ou array com os dados
	 */
	public function buscaUsuario(array $campos, $return_array = false){

	}

	/**
	 * Retorna o tipo de usuário selecionado na instância
	 * @return string tipo do usuário (Pessoa, Instituição ou Admin)
	 */
	public function tipoUsuario(){

	}

} ?>