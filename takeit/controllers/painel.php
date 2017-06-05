<?php defined('BASEPATH') OR exit('OPSSS... Não é permitido direto acesso ao script!!');

class Painel extends CI_Controller{

	function __construct(){
		parent::__construct();
		$this->load->helper(array('url', 'login'));
		testaLogin();
	}

	public function index(){
		$dados["titulo"] = "Meu Painel";
		$dados["css"]    = "painel.css";

		$this->load->view('templates/head', $dados);
		$this->load->view('templates/menu', $dados);
		$this->load->view('painel', $dados);
		$this->load->view('templates/footer');
	}

	public function perfil(){
		$dados["titulo"] = "Perfil do Usuário.php";
		$dados["css"]    = "painel.css";

		$this->load->view('templates/head', $dados);
		$this->load->view('templates/menu', $dados);
		$this->load->view('perfil');
		$this->load->view('templates/footer');
	}

	public function ofertas(){
		$this->load->model('Item_model', 'IM');
		$dados["titulo"] = "Itens para Doar";
		$dados["css"]    = "painel.css";
		$dados["js"]     = "ofertas.js";
		$dados["qualTela"] = 1;

		$dados["user_id"] = $this->session->userdata('user_id');
		$dados["busca_item"] = $this->IM->buscaItemUsuario($dados["user_id"], $status=['Disponível', 'Solicitado']);

		$this->load->view('templates/head', $dados);
		$this->load->view('templates/menu', $dados);
		$this->load->view('itens_painel', $dados);
		$this->load->view('templates/footer');
	}

	public function doados(){
		$this->load->model('Item_model', 'IM');
		$dados["titulo"] = "Itens Doados";
		$dados["css"]    = "painel.css";
		$dados["qualTela"] = 2;

		$dados["user_id"] = $this->session->userdata('user_id');
		$dados["busca_item"] = $this->IM->buscaItemUsuario($dados["user_id"], $status='Doado');

		$this->load->view('templates/head', $dados);
		$this->load->view('templates/menu', $dados);
		$this->load->view('itens_painel', $dados);
		$this->load->view('templates/footer');

	}

	public function interesses(){
		$this->load->model('Item_model', 'IM');
		$dados["titulo"] = "Itens Para Receber";
		$dados["css"]    = "painel.css";
		$dados["qualTela"] = 3;

		$dados["user_id"] = $this->session->userdata('user_id');
		//$dados["busca_item"] = $this->IM->buscaItemUsuario($dados["user_id"]);

		$this->load->view('templates/head', $dados);
		$this->load->view('templates/menu', $dados);
		$this->load->view('itens_painel', $dados);
		$this->load->view('templates/footer');

	}


	public function recebidos(){
		$this->load->model('Item_model', 'IM');
		$dados["titulo"] = "Itens Recebidos";
		$dados["css"]   = "painel.css";
		$dados["qualTela"] = 4;

		$dados["user_id"] = $this->session->userdata('user_id');
		//$dados["busca_item"] = $this->IM->buscaItemUsuario($dados["user_id"]);

		$this->load->view('templates/head', $dados);
		$this->load->view('templates/menu', $dados);
		$this->load->view('itens_painel');
		$this->load->view('templates/footer');
	}

	public function chat(){
		$dados["titulo"] = "Chat";
		$dados["css"]    = "menuChat.css";
		$dados["css2"]   = "chat.css";

		$this->load->view('templates/head', $dados);
		$this->load->view('templates/menu', $dados);
		$this->load->view('templates/menuChat', $dados);
		$this->load->view('chat', $dados);
		$this->load->view('templates/footer');
	}

	
}