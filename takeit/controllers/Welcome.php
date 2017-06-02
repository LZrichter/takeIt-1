<?php defined('BASEPATH') OR exit('OPSSS... Não é permitido direto acesso ao script!!');

class Welcome extends CI_Controller{

	function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->helper('login');

		if(testaLogin(true)) 
			redirect(base_url() . "doacoes", "refresh");
	}

	public function index(){
		
		$dados["titulo"] = "Welcome";
		$dados["css"]    = "welcome.css";
		$dados["js"]	 = "welcome.js";

		$this->load->model("welcome_model","ini");

		$dados["teste"] = $this->ini->teste();

		$this->load->view('templates/head', $dados);
		$this->load->view('templates/menuWelcome');
		$this->load->view('welcome', $dados);
		$this->load->view('templates/footer');
	}
}

