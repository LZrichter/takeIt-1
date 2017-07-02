<?php defined('BASEPATH') OR exit('OPSSS... Não é permitido direto acesso ao script!!');

class Instituicoes extends CI_Controller{

	function __construct(){
		parent::__construct();
		$this->load->helper('url');
	}

	public function index(){
		$this->load->model("Usuario_model","usuario");
		$this->load->model("Instituicao_model","model");

		$result = $this->model->todasInstituicoes();	
		
		if(isset($result["tipo"]) && $result["tipo"] == "erro")
			$dados["mensagem"] = $result["msg"];
		else
			$dados["instituicoes"] = $result;

		$dados["titulo"] = "Instituições";
		$dados["dataTable"] = true;
		$dados["css"]   = "instituicoes.css";
		$dados["css2"]   = "dataTables.bootstrap.min.css";
		$dados["js"]   = "instituicoes.js";
		

		$this->load->view('templates/head', $dados);
		$this->load->view('templates/menu', $dados);
		$this->load->view('instituicoes', $dados);
		$this->load->view('templates/footer', $dados);
	}

	public function intituicoesInteressadas($index){
		
		$inst_session = $this->session->userdata('intituicoes_interessadas');
		$this->load->model("Usuario_model","usuario");
		$this->load->model("Instituicao_model","IM");
		$result = Array();

		if (isset($inst_session[$index])) {	
			foreach ($inst_session[$index] as $key => $campo)
				array_push($result, $this->IM->selecionaInstituicao($campo["instituicao_id"], TRUE));
		}
		
		if(isset($result["tipo"]) && $result["tipo"] == "erro")
			$dados["mensagem"] = $result["msg"];
		else
			$dados["instituicoes"] = $result;

		$dados["titulo"] = "Instituições";
		$dados["dataTable"] = true;
		$dados["css"]   = "instituicoes.css";
		$dados["css2"]   = "dataTables.bootstrap.min.css";
		$dados["js"]   = "instituicoes.js";
		

		$this->load->view('templates/head', $dados);
		$this->load->view('templates/menu', $dados);
		$this->load->view('instituicoes', $dados);
		$this->load->view('templates/footer', $dados);
	}
}