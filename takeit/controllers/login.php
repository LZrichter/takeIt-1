<?php defined('BASEPATH') OR exit('OPSSS... Não é permitido direto acesso ao script!!');

class Login extends CI_Controller{

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
		$this->load->view('login', $dados);
		$this->load->view('templates/footer');
	}
}
