<?php defined('BASEPATH') OR exit('OPSSS... Não é permitido direto acesso ao script!!');

class Usuario extends CI_Controller{

	function __construct(){
		parent::__construct();
		$this->load->helper('url');
	}

	public function index(){
		
		$dados["titulo"] = "Usuário";

		$this->load->model("usuario_model","user");
		$res = $this->user->selecionaUsuario(1, true);

		$dados["dado"] = $this->user->erro;
		$dados["nome"] = $res["nome"];

		$this->load->view('templates/head', $dados);
		$this->load->view('templates/menu');
		$this->load->view('usuario', $dados);
		$this->load->view('templates/footer');
	}
}

