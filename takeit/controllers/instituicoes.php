<?php defined('BASEPATH') OR exit('OPSSS... Não é permitido direto acesso ao script!!');

class Instituicoes extends CI_Controller{

	function __construct(){
		parent::__construct();
		$this->load->helper('url');
	}

	public function index(){
		$dados["titulo"] = "Instituições";
		$dados["dataTable"] = true;
		$dados["css"]    = "menuDoacoes.css";
		$dados["css2"]   = "instituicoes.css";
		$dados["js"]   = "menuDoacoes.js";
		$dados["js2"]   = "instituicoes.js";

		$this->load->view('templates/head', $dados);
		$this->load->view('templates/menu', $dados);
		$this->load->view('templates/menuDoacoes', $dados);
		$this->load->view('instituicoes');
		$this->load->view('templates/footer');
	}
}