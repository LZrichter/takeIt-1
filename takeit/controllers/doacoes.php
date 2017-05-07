<?php defined('BASEPATH') OR exit('OPSSS... Não é permitido direto acesso ao script!!');

class Doacoes extends CI_Controller{

	function __construct(){
		parent::__construct();
		$this->load->helper('url');
	}

	public function index(){
		
		$dados["titulo"] = "Doações";
		$dados["logado"] = true;
		$dados["css"]    = "menuDoacoes.css";

		// $this->load->model("inicio_model","ini");
		// $dados["teste"] = $this->ini->teste();
		// $this->load->model("usuario_model","user");

		$this->load->view('templates/head', $dados);
		$this->load->view('templates/menu', $dados);
		$this->load->view('templates/menuDoacoes', $dados);
		$this->load->view('doacoes', $dados);
		$this->load->view('templates/footer');
	}
}
