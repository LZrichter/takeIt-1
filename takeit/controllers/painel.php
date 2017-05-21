<?php defined('BASEPATH') OR exit('OPSSS... Não é permitido direto acesso ao script!!');

class Painel extends CI_Controller{

	function __construct(){
		parent::__construct();
		$this->load->helper('url');
	}

	public function index(){
		$dados["titulo"] = "Meu Painel";

		$this->load->view('templates/head', $dados);
		$this->load->view('templates/menu', $dados);
		// view resumo
		$this->load->view('templates/footer');
	}


	public function adquiridos(){
		$dados["titulo"] = "Itens Adquiridos";
		$dados["css"]    = "menuDoacoes.css";
		$dados["css2"]   = "adquiridos.css";
		$dados["js"]   = "menuDoacoes.js";

		$this->load->view('templates/head', $dados);
		$this->load->view('templates/menu', $dados);
		$this->load->view('templates/menuDoacoes', $dados);
		$this->load->view('adquiridos');
		$this->load->view('templates/footer');
	}
}