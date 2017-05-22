<?php defined('BASEPATH') OR exit('OPSSS... Não é permitido direto acesso ao script!!');

class Cadastro extends CI_Controller{

	function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->helper('form');
	}

	public function index(){

		$dados["css"]    = "welcome.css";
		$dados["js"]	 = "welcome.js";

		//$this->load->model("usuario_model","user");
		$this->load->view('templates/head', $dados);
		$this->load->view('templates/menuWelcome');
		$this->load->view('cadastro', $dados);
		$this->load->view('templates/footer');
	}

	public function licenca_uso(){
		
		$dados["titulo"] = "Licença de Uso do sistema takeIt";
		$dados["slogan"] = "TakeIt - Ajude quem precisa, doando o que você não precisa.";
		$dados["css"]    = "welcome.css";

		//$this->load->model("usuario_model","user");
		$this->load->view('templates/head', $dados);
		$this->load->view('licenca_uso', $dados);
		$this->load->view('templates/footer');
	}
}
