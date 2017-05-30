<?php defined('BASEPATH') OR exit('OPSSS... Não é permitido direto acesso ao script!!');

class Painel extends CI_Controller{

	function __construct(){
		parent::__construct();
		$this->load->helper('url');
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


	public function itens_recebidos(){
		$dados["titulo"] = "Itens Recebidos";
		$dados["css"]   = "painel.css";

		$this->load->view('templates/head', $dados);
		$this->load->view('templates/menu', $dados);
		$this->load->view('itens_recebidos');
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