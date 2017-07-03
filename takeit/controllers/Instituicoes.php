<?php defined('BASEPATH') OR exit('OPSSS... Não é permitido direto acesso ao script!!');

class Instituicoes extends CI_Controller{

	function __construct(){
		parent::__construct();
		$this->load->helper('url');

		$this->load->helper('login');
		testaLogin();
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

	public function categorias(){
		$dados["css"]  = "painel.css";
		$dados["js"]  = "categorias.js";

		$this->load->model('Usuario_model', 'user');
		$usuario = $this->user->selecionaUsuario($this->session->userdata('user_id'), TRUE);
		$dados["usuario"]["nivel"] = $usuario["nivel"];

		$this->load->model('Categoria_model', 'cat');
		$dados["categorias"] = $this->cat->buscaCategorias();

		$this->load->model('Instituicao_model', 'inst');
		$dados["categorias_interesse"] = $this->inst->buscaCategoriasInteresse($this->session->userdata('user_id'));

		$this->load->view('templates/head', $dados);
		$this->load->view('templates/menu', $dados);
		$this->load->view('categorias', $dados);
		$this->load->view('templates/footer');
	}

	public function atualiza_categorias(){
		if(!empty($this->input->post()))
			$categorias = $this->input->post()['categoria'];
		else
			$categorias[0] = NULL;

		$this->load->model('Instituicao_model', 'inst');
		$resposta = $this->inst->associarInstituicaoCategorias($categorias);

		echo json_encode($resposta);
		return;
	}
}