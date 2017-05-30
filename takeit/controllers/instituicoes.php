<?php defined('BASEPATH') OR exit('OPSSS... Não é permitido direto acesso ao script!!');

class Instituicoes extends CI_Controller{

	function __construct(){
		parent::__construct();
		$this->load->helper('url');
	}

	public function index(){

		$this->load->model("Instituicao_model","model");
		$cnpj = 1; // SÓ PRA NÃO DAR ERRO
		$result = $this->model->buscaInstituicao($cnpj);

		if(isset($result["Error"])){
			$dados["sqlError"] = $result["Error"];
		} else {
			$dados["instituicoes"] = $result;
		}

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
		$this->load->view('instituicoes');
		$this->load->view('templates/footer', $dados);
	}
}