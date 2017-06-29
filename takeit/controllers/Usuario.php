<?php defined('BASEPATH') OR exit('OPSSS... Não é permitido direto acesso ao script!!');

class Usuario extends CI_Controller{

	function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->helper('login');

		testaLogin();
	}

	public function index(){
		$dados["titulo"] = "Usuário";
		$dados["js"]	 = "jquery.mask.js";

		$this->load->model('usuario_model', 'user');
		$res = $this->user->selecionaUsuario(1, true);

		$dados["dado"] = $this->user->erro;
		$dados["nome"] = $res["nome"];

		$this->load->view('templates/head', $dados);
		$this->load->view('templates/menu');
		$this->load->view('usuario', $dados);
		$this->load->view('templates/footer');
	}

	/**
	 * Busca todos os dados do usuário e carrega a view que os exibe
	 * @return void
	 */
	public function perfil(){
		$dados["css"]    = "painel.css";
		$dados["js"]	 = "jquery.mask.js";
		$dados["js2"] 	 = "perfil.js";

		$this->load->model('usuario_model', 'user');
		$dados["usuario"] = $this->user->selecionaUsuario($this->session->userdata('user_id'), TRUE);
		$dados["cpf"] = $this->session;

		$this->load->model("CidadeEstado_model", "CEM");
		$dados["estados"] = $this->CEM->todosEstados();
		$dados["cidades"] = $this->CEM->selecionaCidades($dados['usuario']['estado_id']);

		$this->load->view('templates/head', $dados);
		$this->load->view('templates/menu', $dados);
		$this->load->view('perfil', $dados);
		$this->load->view('templates/footer');
	}

	/**
	 * Salva os dados do perfil usuário preenchidos no formulário
	 * @return void Da echo em um json de resultado
	 */
	public function alterarPerfil(){
		foreach($this->input->post() as $key => $value)
			$$key = $value;

		$this->load->model("Usuario_model", "user");
		$resposta = $this->user->alteraUsuario($user_id, $this->input->post());

		if($resposta["tipo"] == "sucesso"){
			if($user_nivel == "Pessoa"){
				$this->load->model("Pessoa_model", "pessoa");
				$resposta = $this->pessoa->alteraPessoa($user_id, $cpf);

				echo json_encode($resposta); 
				return;
			}else if($user_nivel == "Instituição"){
				$this->load->model("Instituicao_model", "instituicao");
				$resposta = $this->instituicao->alteraInstituicao($user_id, $cnpj, $website);
				
				echo json_encode($resposta);
				return;
			}else echo json_encode(["tipo" => "erro", "msg" => "Problema inesperado no sistema. Tente novamente mais tarde!"]);
		}else echo json_encode(["tipo" => "erro", "msg" => "Erro ao atualizar dados da conta. Tente novamente mais tarde!"]);
	}

	/**
	 * Será chamada por ajax para buscar as cidades
	 * @return json Da um echo em um JSON
	 */
	public function selecionaCidades(){
		$this->load->model("CidadeEstado_model", "CEM");

		$id_estado = $this->uri->segment(3, null);
		if(isset($id_estado) && !is_null($id_estado) && !empty($id_estado)){
			$cidades = $this->CEM->selecionaCidades((int) $id_estado);	

			if($cidades !== FALSE && !isset($cidades["tipo"])){
				echo json_encode(["cidades" => $cidades]);
				return;
			}
		}
		echo json_encode(["tipo" => "erro", "msg" => "Ocorreu um erro ao sistema, tente novamente mais tarde."]);
	}
}

