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

		/* Carrega todos os dados do item que foi selecionado*/
		$this->load->model("item_model", "item");
		$dados_item = $this->item->buscaItemPorId($idItem)[0];

		foreach($dados_item as $chave => $valor)
			$dados[$chave] = $valor; // Carregando os dados no array de dados

		/* Realiza o teste se o usuário é o dono do item ou então possui um interesse no item */
		$this->load->model("Interesse_model", "interesse");
		if($dados["usuario_id"] == $this->session->userdata("user_id")){ // Dono do item
			$dados["usuario_doador"] = true; // Caso for o usuário que está realizando a doação, a lista de user será mostrada
			$dados["tipo_pessoa"] = "Doador";
		}else{
			if(!$this->interesse->testaInteresseItem($dados["item_id"], $this->session->userdata("user_id"))){ // Possui interesse no item
				header("Location: ".base_url()."doacoes");
				exit;
			}

			$dados["usuario_doador"] = false;
			$dados["tipo_pessoa"] = "Beneficiário";
		}

		// Busca a lista de todas as pessoa interessadas
		$dados["interessados"] = $this->interesse->todosInteressados($dados["item_id"]);
		if(!isset($dados["interessados"]["tipo"]) || (isset($dados["interessados"]["tipo"]) && $dados["interessados"]["tipo"] != "erro"))
			$dados["interesse_id"] = $dados["interessados"][0]["interesse_id"];

		if(!$dados["usuario_doador"]){
			/* Busca os dados para o chat quando ele deve ser mostrado como a primeira coisa */
			$this->load->model("Chat_model", "chat");
			$dados["chat"]["chat"] = $this->chat->porcaoChatLimite($dados["interesse_id"]);

			/* Busca os dados do usuário em si */
			$this->load->model("Usuario_model", "user");
			$this->user->selecionaUsuario($this->session->userdata("user_id"));
			$dados["chat"]["usuario_nome"] = $this->user->nome;
			$dados["chat"]["imagem_link"] = base_url().substr($this->user->imagem_caminho."/".$this->user->imagem_nome, 2);
		}
		
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

	/**
	 * Salva uma mensagem nova para o chat
	 * @return string echo em um JSON com os dados da mensagem que foi salva
	 */
	public function salvaMensagem(){
		$this->load->model("Chat_model", "chat");

		$dados = $this->input->post();

		$retorno = $this->chat->salvaMensagem($dados["msg"], $dados["interesse_id"], $dados["tipo_pessoa"]);
		echo json_encode($retorno);
	}

	/**
	 * Busca as novas mensagens para o chat
	 * @return string echo em um JSON para ser retornado para o ajax
	 */
	public function buscarMensagensNovas(){
		$this->load->model("Chat_model", "chat");

		$idInteresse = (isset($this->input->post()["idInteresse"]) ? $this->input->post()["idInteresse"] : "");
		$IDUltimaMsg = (isset($this->input->post()["IDUltimaMsg"]) ? $this->input->post()["IDUltimaMsg"] : "");

		if(!empty($idInteresse) && !empty($IDUltimaMsg))
			echo json_encode($this->chat->novasMensagens($idInteresse, $IDUltimaMsg));
		else return;
	}
}
