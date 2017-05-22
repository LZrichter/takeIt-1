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

		$dados["quantidadePorPagina"] = 20;
		$dados["paginaAtual"] = 1;
		$dados["filtroUF"] = "RS";
		$dados["filtroMunicipio"] = "Alecrim";
		$dados["filtroCategoria"] = "Chinelos";
		$dados["filtroBusca"] = "CEO";

		$this->load->model("Instituicao_model","model");
		$result = $this->model->buscaInstituicoes($dados);
		if(isset($result["Error"])){
			$dados["sqlError"] = $result["Error"];
		}
		echo "<br/><br/><br/><br/><br/><br/><pre>";
		print_r($result);
		echo "</pre>";

		$this->load->view('templates/head', $dados);
		$this->load->view('templates/menu', $dados);
		$this->load->view('templates/menuDoacoes', $dados);
		$this->load->view('instituicoes');
		$this->load->view('templates/footer', $dados);
	}
}