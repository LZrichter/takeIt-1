<?php defined('BASEPATH') OR exit('OPSSS... Não é permitido direto acesso ao script!!');

class Login extends CI_Controller{

	function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->helper('form');
	}

	public function index(){
		
		$dados["titulo"] = "Login";
		$dados["slogan"] = "TakeIt - Ajude quem precisa, doando o que você não precisa.";
		$dados["css"]    = "login.css";
		$dados["js"]	 = "login.js";

		//$this->load->model("usuario_model","user");
		$this->load->view('templates/head', $dados);
		$this->load->view('templates/menuWelcome');
		$this->load->view('login', $dados);
		$this->load->view('templates/footer');
	}
}
