<?php defined('BASEPATH') OR exit('OPSSS... Não é permitido direto acesso ao script!!');

class Inicio extends CI_Controller{

	function __construct(){
		parent::__construct();
	}

	public function index(){
		$dados["titulo"] = "Inicio";

		$this->load->model("inicio_model","ini");

		$dados["teste"] = $this->ini->teste();

		$this->load->view('inicio', $dados);
	}
}
