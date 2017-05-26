<?php defined('BASEPATH') OR exit('OPSSS... Não é permitido direto acesso ao script!!');

class Doacoes extends CI_Controller{

	function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->model("CidadeEstado_model", "CEM");
		$this->load->model("Categoria_model", "CM");
	}

	public function index(){
		
		$dados["titulo"] = "Doações";
		$dados["css"]    = "menuDoacoes.css";
		$dados["css2"]   = "itens.css";
		$dados["js"]     = "menuDoacoes.js";

		// $this->load->model("inicio_model","ini");
		// $dados["teste"] = $this->ini->teste();
		// $this->load->model("usuario_model","user");

		$this->load->view('templates/head', $dados);
		$this->load->view('templates/menu', $dados);
		$this->load->view('templates/menuDoacoes', $dados);
		$this->load->view('doacoes', $dados);
		$this->load->view('templates/footer');
	}
	
	public function item($id = 0){

		$dados["itemId"] = $id;
		$dados["titulo"] = "Doações";
		$dados["css"]    = "item.css";
		$dados["js"]    = "imageZoom.js";

		$this->load->view('templates/head', $dados);
		$this->load->view('templates/menu', $dados);
		$this->load->view('item', $dados);
		$this->load->view('templates/footer');
	}

	public function cadastrarItem(){

		$dados["titulo"] = "Cadastrar Item";
		$dados["css"]    = "item.css";
		$dados["js"]     = "doacao.js";

		$this->load->view('templates/head', $dados);
		$this->load->view('templates/menu', $dados);
		$this->load->view('doacao', $dados);
		$this->load->view('templates/footer');
	}

	public function carregaEstadosMenu(){
		$dados = $this->CEM->todosEstados();
		echo( json_encode($dados) );
	}

	public function carregaMunicipiosMenu($idEstado){
		$dados = $this->CEM->selecionaCidades($idEstado);
		echo( json_encode($dados) );
	}

	public function carregaCategoriasMenu(){
		$dados = $this->CM->buscaCategorias();
		echo( json_encode($dados) );
	}

	public function filtraDoacoes($idCategoria, $idCidade){
		/*
		* TODO
		* filtra doaçoes pela categoria e cidade pelo menu lateral 
		*/
	
		

	}
}
