<?php defined('BASEPATH') OR exit('OPSSS... Não é permitido direto acesso ao script!!');

class Chat extends CI_Controller{

	function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->helper('login');

		testaLogin();
	}

	public function index(){
		$dados["css"] = "chat.css";
		$dados["js"]  = "chat.js";

		//$this->load->model("usuario_model","user");
		$this->load->view('templates/head', $dados);
		$this->load->view('templates/menu', $dados);
		$this->load->view('chat', $dados);
		$this->load->view('templates/footer');
	}

	public function chatMeio(){
		$this->load->view("chat_principal");
	}
}
