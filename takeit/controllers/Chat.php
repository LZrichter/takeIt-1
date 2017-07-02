<?php defined('BASEPATH') OR exit('OPSSS... Não é permitido direto acesso ao script!!');

class Chat extends CI_Controller{

	function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->helper('login');

		testaLogin();

		$url = explode("-", $this->uri->segment(2));
		$method = array_pop($url);

		if(!is_int($method) && method_exists($this, $method)){
			$this->$method();
			exit;
		}
	}

	public function index(){
		$dados["css"] = "chat.css";
		$dados["js"]  = "chat.js";

		// Se não tem nenhum item selecionado, redireciona para as doações
		if(empty(trim($this->uri->segment(2)))){
			header("Location: ".base_url()."doacoes");
			exit;
		}

		$exp = explode("-", $this->uri->segment(2));
		$idItem = array_pop($exp); //Pega o ID do item através do ultimo elemento do array

		$this->load->model("item_model", "item");
		$dados_item = $this->item->buscaItemPorId($idItem)[0];

		foreach($dados_item as $chave => $valor)
			$dados[$chave] = $valor;

		$this->load->model("Interesse_model", "interesse");

		if($dados["usuario_id"] == $this->session->userdata("user_id")){
			$dados["mostrar_lista"] = true; // Caso for o usuário que está realizando a doação, a lista de user será mostrada
			$dados["tipo_pessoa"] = "Doador";
		}else{
			if(!$this->interesse->testaInteresseItem($dados["item_id"], $this->session->userdata("user_id"))){
				header("Location: ".base_url()."doacoes");
				exit;
			}

			$dados["mostrar_lista"] = false;
			$dados["tipo_pessoa"] = "Beneficiário";
		}

		$dados["interessados"] = $this->interesse->todosInteressados($dados["item_id"]);
		$dados["interesse_id"] = $dados["interessados"][0]["interesse_id"];

		$dados["debbug"] = $dados_item;

		$this->load->view('templates/head', $dados);
		$this->load->view('templates/menu', $dados);
		$this->load->view('chat', $dados);
		$this->load->view('templates/footer');
	}

	public function chatInicial(){
		$this->load->model("Chat_model", "chat");

		foreach($this->input->post() as $chave => $valor)
			$dados[$chave] = $valor;

		$dados["chat"] = $this->chat->porcaoChatLimite($dados["interesse_id"]);

		echo $this->load->view("chat_principal", $dados)->output->final_output;
	}

	public function salvaMensagem(){
		$this->load->model("Chat_model", "chat");

		$dados = $this->input->post();

		$retorno = $this->chat->salvaMensagem($dados["msg"], $dados["interesse_id"], $dados["tipo_pessoa"]);
		echo json_encode($retorno);
	}
}
