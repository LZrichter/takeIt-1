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

		$this->load->model("Chat_model", "chat");
		
		$this->load->model("Doacao_model", "doacao");
		$qtde_doada = $this->doacao->qtdeDoadaItem($dados["item_id"]);

		$this->load->model("Item_model", "item");
		$item = $this->item->buscaItemPorId($dados["item_id"]); // Busca o id do usuário a partir do item

		$dados["qtde"] = ["itens" => $item[0]["item_qtde"], "doados" => $qtde_doada];

		if($dados["usuario_doador"]){
			// Busca a lista de todas as pessoa interessadas
			$dados["interessados"] = $this->interesse->todosInteressados($dados["item_id"]);
			if(!isset($dados["interessados"]["tipo"]) || (isset($dados["interessados"]["tipo"]) && $dados["interessados"]["tipo"] != "erro"))
				$dados["interesse_id"] = $dados["interessados"][0]["interesse_id"];

			$dados["conta_nao_lidas"] = $this->chat->qtdeMsgsNaoLidasDoador($dados["item_id"]);
		}else{
			// Busca os dados do interesse para pegar o usuário a partir do item
			$chat_interesse = $this->interesse->buscaInteresseItemUsuario($idItem, $this->session->userdata("user_id"));
			$dados["interesse_id"] = $chat_interesse[0]["interesse_id"];

			/* Busca os dados para o chat quando ele deve ser mostrado como a primeira coisa */
			$this->chat->tipoPessoa = $dados["tipo_pessoa"];
			$dados["chat"]["chat"] = $this->chat->porcaoChatLimite($dados["interesse_id"]);

			/* Verifica se o usuário que está logado no momento recebeu uma doação deste item */
			$dados["usuario_doacao"] = $this->doacao->possuiDoacaoitem($this->session->userdata("user_id"), $dados["item_id"]);

			/* Verifica se o chat com esse usuário foi bloqueado */
			$dados["chat_bloqueado"] = $this->chat->testeChatCancelado($dados["interesse_id"]);

			/* Busca os dados do usuário em si */
			$this->load->model("Usuario_model", "user");
			$this->user->selecionaUsuario($item[0]["usuario_id"]);

			$dados["chat"]["usuario_nome"] = $this->user->nome;
			
			$dados["chat"]["imagem_link"] = ((is_null($this->user->imagem_caminho)) ? 
				base_url()."assets/img/painel_perfil.png" : 
				base_url().substr($this->user->imagem_caminho."/".$this->user->imagem_nome, 2));
		}
		
		$this->load->view('templates/head', $dados);
		$this->load->view('templates/menu', $dados);
		$this->load->view('chat', $dados);
		$this->load->view('templates/footer');
	}

	/**
	 * Mostra o chat inicial quando clicado no nome de uma pessoa
	 * @return html retorna uma view para o ajax
	 */
	public function chatInicial(){
		$this->load->model("Chat_model", "chat");

		foreach($this->input->post() as $chave => $valor)
			$dados[$chave] = $valor;

		$this->load->model("Doacao_model", "doacao");
		$qtde_doada = $this->doacao->qtdeDoadaItem($dados["item_id"]);

		/* Verifica se o usuário que está logado no momento recebeu uma doação deste item */
		$dados["usuario_doacao"] = $this->doacao->possuiDoacaoitem($dados["usuario_id"], $dados["item_id"]);

		/* Verifica se o chat com esse usuário foi bloqueado */
		$dados["chat_bloqueado"] = $this->chat->testeChatCancelado($dados["interesse_id"]);

		$this->load->model("Item_model", "item");
		$item = $this->item->buscaItemPorId($dados["item_id"]); // Busca o id do usuário a partir do item

		$dados["qtde"] = ["itens" => $item[0]["item_qtde"], "doados" => $qtde_doada];
		$dados["chat"] = $this->chat->porcaoChatLimite($dados["interesse_id"]);
		$dados["js"]   = "notificacoes.js";

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

	/**
	 * Busca a quantidade de mensagens que ainda não foram lidas
	 * @return string JSON com os dados
	 */
	public function buscaCountNaoLidas(){
		$this->load->model("Chat_model", "chat");
		echo json_encode($this->chat->qtdeMsgsNaoLidasDoador($this->input->post()["item_id"]));
	}

	/**
	 * Doa o item a partir de sua quantidade
	 * @return string echo em um JSON da resposta
	 */
	public function doarItem(){
		$dados = $this->input->post();

		$this->load->model("Doacao_model", "doacao");
		$qtde_doada = $this->doacao->qtdeDoadaItem($dados["item_id"]);

		$this->load->model("Item_model", "item");
		$item = $this->item->buscaItemPorId($dados["item_id"]);

		$restante = $item[0]["item_qtde"] - $qtde_doada;
		if($restante >= $dados["qtde_itens"]){
			if($resporta = $this->doacao->registraDoacao([
				"quantidade" => $dados["qtde_itens"],
				"interesse_id" => $dados["interesse_id"],
				"agradecimento" => ""
			]) === true){
				$qtde_doada_nova = $this->doacao->qtdeDoadaItem($dados["item_id"]);
				if($qtde_doada_nova == $item[0]["item_qtde"])
					$this->item->alteraStatusItemPorId($dados["item_id"], "Doado");

				echo json_encode(["tipo" => "sucesso", "msg" => "OK"]);	
			}
			else echo json_encode($resposta);
		}else echo json_encode(["tipo" => "erro", "msg" => "Não possui itens suficientes!"]);
	}

	/**
	 * Cancela o bate-papo
	 * @return string Echo de um json de resposta
	 */
	public function cancelarBatePapo(){
		$this->load->model("Chat_model", "chat");

		echo json_encode($this->chat->cancelarBatePapo($this->input->post()["interesse_id"]));
	}
}
