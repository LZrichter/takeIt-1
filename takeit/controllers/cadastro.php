<?php defined('BASEPATH') OR exit('OPSSS... Não é permitido direto acesso ao script!!');

class Cadastro extends CI_Controller{

	function __construct(){
		parent::__construct();
		$this->load->helper('url');
	}

	public function index(){
		$dados["titulo"] = "Cadastre-se";
		$dados["slogan"] = "TakeIt - Ajude quem precisa, doando o que você não precisa.";
		$dados["css"]    = "welcome.css";
		$dados["css2"]   = "cadastro.css";	
		$dados["js"]	 = "jquery.mask.js";
		$dados["js2"] 	 = "cadastro.js";

		$this->load->model("CidadeEstado_model", "CEM");
		$dados["estados"] = $this->CEM->todosEstados();

		$this->load->view('templates/head', $dados);
		$this->load->view('templates/menuWelcome');
		$this->load->view('cadastro', $dados);
		$this->load->view('templates/footer');
	}

	public function salvarUsuario(){
		foreach($_REQUEST as $k => $v)
			$$k = $v;

		$this->load->model("Usuario_model", "user");

		$resposta = $this->user->insereUsuario($_REQUEST);

		if($resposta["tipo"] == "sucesso"){
			if($tipo_usuario == "Pessoa"){
				$this->load->model("Pessoa_model", "pessoa");

				if($res = $this->pessoa->inserePessoa(["idUsuario" => $this->user->getId(), "cpf" => $cpf])){
					echo json_encode(["tipo" => "sucesso", "msg" => "Cadastro efetuado com sucesso."]);
				}else{
					$this->user->db->query("rollback");
					echo json_encode($res);

					return;
				}
			}else{
				echo "Instituição";
			}
		}else{
			$this->user->db->query("rollback");
			echo json_encode($resposta);	
		} 
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

			if($cidades !== FALSE){
				echo json_encode(["cidades" => $cidades]);

				return;
			}
		}

		echo json_encode(["erro" => "Ocorreu um erro ao sistema, tente novamente mais tarde."]);
	}

	public function licencaUso(){
		$dados["titulo"] = "Licença de Uso do sistema takeIt";
		$dados["slogan"] = "TakeIt - Ajude quem precisa, doando o que você não precisa.";
		$dados["css"]    = "welcome.css";
		
		$this->load->view('templates/head', $dados);
		$this->load->view('licenca_uso', $dados);
		$this->load->view('templates/footer');
	}
}
