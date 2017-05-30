<?php defined('BASEPATH') OR exit('OPSSS... Não é permitido direto acesso ao script!!');

class Instituicoes extends CI_Controller{

	function __construct(){
		parent::__construct();
		$this->load->helper('url');
	}

	public function index(){
		$this->load->model("Instituicao_model","model");
		$result = $this->model->todasInstituicoes();

		// var_dump($result); return;

		if(isset($result["tipo"]) && $result["tipo"] == "erro")
			$dados["mensagem"] = $result["msg"];
		else
			$dados["instituicoes"] = $result;

		$dados["titulo"] = "Instituições";
		$dados["dataTable"] = true;
		$dados["css"]   = "instituicoes.css";
		$dados["css2"]   = "jquery.dataTables.min.css";
		$dados["js"]   = "instituicoes.js";
		
		//echo "<br/><br/><br/><br/><br/><br/><pre>";
		//print_r($result);
		//echo "</pre>";

		$this->load->view('templates/head', $dados);
		$this->load->view('templates/menu', $dados);
		$this->load->view('instituicoes', $dados);
		$this->load->view('templates/footer', $dados);
	}
}