<?php defined('BASEPATH') OR exit('OPSSS... Não é permitido direto acesso ao script!!');

class Painel extends CI_Controller{

	function __construct(){
		parent::__construct();
		$this->load->helper(array('url', 'login', 'funcoes_padroes'));
		testaLogin();
	}

	public function index(){
		if ($this->session->userdata('user_tipo') == 'Admin') {
			
			$this->load->model('Denuncia_model', "DM");
			$this->load->model('Item_model', 'IM');
			$this->load->model('usuario_model', 'UM');

			$dados["titulo"] = "Painel Administrativo";	
			$dados["css"] = "painel.css";

			$dados["pendentes"] = count($this->DM->listaDenuncias('Aberta'));
			$dados["ignoradas"] = count($this->DM->listaDenuncias('Ignorada'));
			$dados["resolvidas"] = count($this->DM->listaDenuncias('Resolvida'));
			$dados["itens_cancelados"] = count($this->IM->buscaQtdeItens('Cancelado'));
			$dados["itens_doados"] = count($this->IM->buscaQtdeItens('Doado'));
			$dados["users_bloqueados"] = count($this->UM->buscaUsuariosAtivosBloqueados(0));

			
			$this->load->view('templates/head', $dados);
			$this->load->view('templates/menu', $dados);
			$this->load->view('painel_admin', $dados);
			$this->load->view('templates/footer');
		}else{
			$dados["titulo"] = "Meu Painel";
			$dados["css"]    = "painel.css";

			$this->load->view('templates/head', $dados);
			$this->load->view('templates/menu', $dados);
			$this->load->view('painel', $dados);
			$this->load->view('templates/footer');
		}

	}

	public function ofertas(){
		$this->load->model('Item_model', 'IM');
		$this->load->model('Instituicao_model', 'INM');
		$this->load->helper("funcoes_padroes");
		
		$dados["titulo"] = "Itens para Doar";
		$dados["css"]    = "painel.css";
		$dados["js"]     = "ofertas.js";
		$dados["qualTela"] = 1;

		$dados["user_id"] = $this->session->userdata('user_id');
		$dados["busca_item"] = $this->IM->buscaItemUsuario($dados["user_id"], $status=['Disponível', 'Solicitado']);
		$dados["instituicoes_interessadas"] = array();
		$dados["session"] = $this->session->userdata();
		
		foreach ($dados["busca_item"] as $key)
			foreach ($key as $campo => $valor)
				if ($campo == "categoria_id")
					array_push($dados["instituicoes_interessadas"], $this->INM->instituicoesInteressadas($valor));
		

		$this->session->set_userdata('intituicoes_interessadas', $dados["instituicoes_interessadas"]);

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
		$this->load->model('Interesse_model', 'IN');

		$dados["titulo"] = "Meus Interesses";
		$dados["css"]    = "painel.css";
		$dados["qualTela"] = 3;

		$dados["user_id"] = $this->session->userdata('user_id');
		$dados["interesses"] = $this->IN->interessesPorUsuario($dados["user_id"]);
		
		if (!isset($dados["interesses"]["tipo"])){
			foreach ($dados["interesses"] as $row)
				foreach ($row as $key => $value)
					$dados["busca_item"][] = $this->IM->buscaItemPorId($value)[0];
		}
		
		$this->load->view('templates/head', $dados);
		$this->load->view('templates/menu', $dados);
		$this->load->view('itens_painel', $dados);
		$this->load->view('templates/footer');

	}


	public function recebidos(){
		$this->load->model('Item_model', 'IM');
		$this->load->model('Doacao_model', 'DM');
		$dados["titulo"] = "Itens Recebidos";
		$dados["css"]   = "painel.css";
		$dados["qualTela"] = 4;

		$dados["user_id"] = $this->session->userdata('user_id');
		$dados["busca_item"] = $this->DM->buscaDoados($dados["user_id"]);

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

	public function notificacao(){

		$this->load->model('Notificacao_model', 'NM');
		$this->load->model('Doacao_model', 'DM');

		$dados["titulo"] = "Notificações";
		$dados["css"] = "welcome.css";
		$dados["js"] = "notificacoes.js";

		$dados["notificacoes"] = $this->NM->buscaNotificacoes($this->session->userdata('user_id'));
		
		$i = 0;
		foreach ($dados["notificacoes"] as $row) {
			if ($row["notificacao_tipo"] == 'doacao_adquirida') {
				if( $this->DM->verificarAgradecimento($row["interesse_id"]) )//ja agradeceu
					$dados['notificacoes'][$i]["ja_agradeceu"] = true;
				else
					$dados['notificacoes'][$i]["ja_agradeceu"] = false;
			}
		$i++;
		}

		$this->load->view('templates/head', $dados);
		$this->load->view('templates/menu', $dados);
		$this->load->view('notificacao', $dados);
		$this->load->view('templates/footer');

	}

	public function getQuantidade(){

		$this->load->model('Notificacao_model', 'NM');
		$quantidade = $this->NM->quantidadeDeNotificacoes($this->session->userdata('user_id'));
		echo( json_encode($quantidade) );

	}

	public function denuncias(){
		if ($this->session->userdata('user_tipo') == 'Admin') {
			
			$this->load->model('Denuncia_model', "DM");
			$this->load->model('Item_model', 'IM');
			$this->load->model('Usuario_model', 'UM');

			$dados["titulo"] = "Denúncias";	
			$dados["css"] = "painel.css";
			$dados["js"] = "reportados.js";

			$dados["denuncia"] = $this->DM->listaDenuncias('Aberta');

			if (!empty($dados["denuncia"]) && isset($dados["denuncia"])) {
				//buscar dados do item
				//buscar dados dos usuario envolvidos com as denuncias
				$dados["usuarios_vacilao"] = array();
				$dados["usuarios_xnove"] = array();
				$dados["item"] = array();

				for($i=0; $i < count($dados["denuncia"]); $i++):
					array_push($dados["usuarios_vacilao"], $this->UM->selecionaUsuario($dados["denuncia"][$i]["usuario_vacilao"], TRUE));
					array_push($dados["usuarios_xnove"], $this->UM->selecionaUsuario($dados["denuncia"][$i]["usuario_xnove"], TRUE));
					if (isset($dados["denuncia"][$i]["item_vacilao"])) {
						array_push( $dados["item"], $this->IM->buscaItemPorId($dados["denuncia"][$i]["item_vacilao"]));
					}
				endfor;
			}

			$this->load->view('templates/head', $dados);
			$this->load->view('templates/menu', $dados);
			$this->load->view('admin_itens_denunciados', $dados);
			$this->load->view('templates/footer');
		}else{
			$this->redirect('/login','refresh');
		}
	}

	public function denunciasIgnoradas(){
		if ($this->session->userdata('user_tipo') == 'Admin') {
			
			$this->load->model('Denuncia_model', "DM");
			//$this->load->model('Item_model', 'IM');
			//$this->load->model('usuario_model', 'UM');

			$dados["titulo"] = "Denúncias Ignoradas";
			$dados["dataTable"] = true;	
			$dados["css"] = "painel.css";
			$dados["css2"]   = "dataTables.bootstrap.min.css";
			$dados["js"]   = "admin.js";
			

			$dados["dados"] = $this->DM->listaDenuncias('Ignorada');

			
			$this->load->view('templates/head', $dados);
			$this->load->view('templates/menu', $dados);
			$this->load->view('admin_template', $dados);
			$this->load->view('templates/footer');
		}else{
			$this->redirect('/login','refresh');
		}
	}

	public function denunciasResolvidas(){
		if ($this->session->userdata('user_tipo') == 'Admin') {
			
			$this->load->model('Denuncia_model', "DM");
			$this->load->model('Item_model', 'IM');
			$this->load->model('usuario_model', 'UM');

			$dados["titulo"] = "Denúncias Resolvidas";	
			$dados["css"] = "painel.css";
			$dados["dataTable"] = true;	
			$dados["css2"]   = "dataTables.bootstrap.min.css";
			$dados["js"]   = "admin.js";
			
			
			$dados["dados"] = $this->DM->listaDenuncias('Resolvida');

			
			$this->load->view('templates/head', $dados);
			$this->load->view('templates/menu', $dados);
			$this->load->view('admin_template', $dados);
			$this->load->view('templates/footer');
		}else{
			$this->redirect('/login','refresh');
		}
	}

	public function doacoesCanceladas(){
		if ($this->session->userdata('user_tipo') == 'Admin') {
			
			// $this->load->model('Denuncia_model', "DM");
			$this->load->model('Item_model', 'IM');
			// $this->load->model('usuario_model', 'UM');

			$dados["titulo"] = "Denúncias Resolvidas";	
			$dados["css"] = "painel.css";
			$dados["dataTable"] = true;	
			$dados["css2"]   = "dataTables.bootstrap.min.css";
			$dados["js"]   = "admin.js";
			
			
			$dados["dados"] = $this->IM->buscaQtdeItens('Cancelado');

			
			$this->load->view('templates/head', $dados);
			$this->load->view('templates/menu', $dados);
			$this->load->view('admin_template', $dados);
			$this->load->view('templates/footer');
		}else{
			$this->redirect('/login','refresh');
		}
	}

	public function usuariosBloqueados(){
		if ($this->session->userdata('user_tipo') == 'Admin') {
			
			$this->load->model('usuario_model', 'UM');

			$dados["titulo"] = "Usuários Bloqueados";	
			$dados["css"] = "painel.css";
			$dados["dataTable"] = true;	
			$dados["css2"]   = "dataTables.bootstrap.min.css";
			$dados["js"]   = "admin.js";			
			
			$dados["dados"] = $this->UM->buscaUsuariosAtivosBloqueados(0);

			$this->load->view('templates/head', $dados);
			$this->load->view('templates/menu', $dados);
			$this->load->view('admin_template', $dados);
			$this->load->view('templates/footer');
		}else{
			$this->redirect('/login','refresh');
		}
	}

	public function doacoesRealizadas(){
		if ($this->session->userdata('user_tipo') == 'Admin') {
			
			// $this->load->model('Denuncia_model', "DM");
			$this->load->model('Item_model', 'IM');
			// $this->load->model('usuario_model', 'UM');

			$dados["titulo"] = "Doações Realizadas";	
			$dados["css"] = "painel.css";
			$dados["dataTable"] = true;	
			$dados["css2"]   = "dataTables.bootstrap.min.css";
			$dados["js"]   = "admin.js";
			
			
			$dados["dados"] = $this->IM->buscaQtdeItens('Doado');

			
			$this->load->view('templates/head', $dados);
			$this->load->view('templates/menu', $dados);
			$this->load->view('admin_template', $dados);
			$this->load->view('templates/footer');
		}else{
			$this->redirect('/login','refresh');
		}
	}

	public function ignorarDenuncia($id){
		if ($this->session->userdata('user_tipo') == 'Admin' && isset($id)) {
			$this->load->model('Denuncia_model', "DM");
			$result = $this->DM->ignorarDenuncia($id);

			if ($result) {
				echo json_encode(array("tipo" => "sucesso", "msg" => "A denúncia foi ignorada com sucesso"));
			}else{
				echo json_encode($result);
			}
			
		}else{
			$this->redirect('/login','refresh');
		}
	}

	public function resolverDenuncia($id){
		if ($this->session->userdata('user_tipo') == 'Admin' && isset($id)) {
			$this->load->model('Denuncia_model', "DM");
			$result = $this->DM->resolverDenuncia($id);

			if ($result) {
				echo json_encode(array("tipo" => "sucesso", "msg" => ". A denúncia foi marcada como resolvida"));
			}else{
				echo json_encode($result);
			}
			
		}else{
			$this->redirect('/login','refresh');
		}
	}

	public function cancelarUsuario(){
		if (isset($_POST["idDenuncia"]) && isset($_POST["idUser"])) {
			$idUser = $_POST["idUser"];
			$idDenuncia = $_POST["idDenuncia"];

			if ($this->session->userdata('user_tipo') == 'Admin') {
				$this->load->model('Denuncia_model', "DM");
				$this->load->model('usuario_model', "UM");
				$this->load->model('Item_model', "IM");
				
				$this->db->trans_begin();
				$userCancelado = $this->UM->bloqueiaUsuario($idUser);
				$itensUsuario = $this->IM->alteraStatusItemPorUsuario($idUser,'Cancelado');

				if($userCancelado && $itensUsuario){
					$result = $this->DM->resolverDenuncia(null, $idUser);

					if ($result){
						$this->db->trans_commit();
						echo json_encode(array("tipo" => "sucesso", "msg" => "O usuário foi bloqueado e todas sua doações foram canceladas com sucesso!"));
					}else{
						$this->db->trans_rollback();
						echo json_encode($result);
					}
				}else{
					echo json_encode($userCancelado);	
				}
			}else{
				$this->redirect('/login','refresh');
			}
		}else{
			echo json_encode(["tipo" => "erro" , "msg" => "Parametros não informados!"]);
		}
		
	}
}